import apiFetch from "@wordpress/api-fetch";
import {
	InnerBlocks,
	useBlockProps,
	useInnerBlocksProps,
} from "@wordpress/block-editor";
import { useEntityProp } from "@wordpress/core-data";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
	useSelect,
	select,
	subscribe,
	useDispatch,
	dispatch,
} from "@wordpress/data";
import { useEntityRecord } from "@wordpress/core-data";
import {
	createElement,
	useCallback,
	memo,
	useMemo,
	useState,
	useEffect,
} from "@wordpress/element";
import { applyFilters } from "@wordpress/hooks";
import {
	Icon,
	styles,
	settings,
	link,
	linkOff,
	brush,
	mediaAndText,
} from "@wordpress/icons";

import {
	PanelBody,
	RangeControl,
	Button,
	Panel,
	PanelRow,
	Dropdown,
	DropdownMenu,
	SelectControl,
	ColorPicker,
	ColorPalette,
	ToolsPanelItem,
	ComboboxControl,
	ToggleControl,
	MenuGroup,
	MenuItem,
	TextareaControl,
	Spinner,
} from "@wordpress/components";
import { __experimentalBoxControl as BoxControl } from "@wordpress/components";

import {
	InspectorControls,
	BlockControls,
	AlignmentToolbar,
	RichText,
} from "@wordpress/block-editor";
import { __experimentalInputControl as InputControl } from "@wordpress/components";
import breakPoints from "../../breakpoints";
const { RawHTML } = wp.element;
import { store } from "../../store";

import PGDropdown from "../../components/dropdown";
import PGLibraryBlockVariations from "../../components/library-block-variations";

import PGtabs from "../../components/tabs";
import PGtab from "../../components/tab";
import PGStyles from "../../components/styles";
import PGCssLibrary from "../../components/css-library";
import metadata from "./block.json";
import PGcssClassPicker from "../../components/css-class-picker";
import customTags from "../../custom-tags";

var myStore = wp.data.select("postgrid-shop");

registerBlockType(metadata, {
	icon: {
		// Specifying a background color to appear with the icon e.g.: in the inserter.
		background: "#fff",
		// Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
		foreground: "#fff",
		// Specifying an icon for the block
		src: (
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36">
				<rect fill="#1d4ed8" y="27.61" width="13.97" height="2" />
				<rect fill="#1d4ed8" x="16.42" y="27.61" width="9.96" height="2" />
				<rect fill="#1d4ed8" y="22.91" width="36" height="2" />
				<rect fill="#1d4ed8" y="18.22" width="36" height="2" />
				<rect fill="#1d4ed8" y="6.39" width="36" height="2.35" />
				<rect fill="#8db1ff" y="13.09" width="10.07" height="2" />
				<rect fill="#8db1ff" x="15.29" y="13.09" width="10.07" height="2" />
			</svg>
		),
	},

	edit: function (props) {
		var attributes = props.attributes;
		var setAttributes = props.setAttributes;
		var context = props.context;
		var clientId = props.clientId;

		var blockId = attributes.blockId;

		var blockIdX = attributes.blockId
			? attributes.blockId
			: "pg" + clientId.split("-").pop();
		var blockClass = "." + blockIdX;

		var meta = attributes.meta;
		var template = attributes.template;
		var templateLoop = attributes.templateLoop;

		var prefix = attributes.prefix;
		var postfix = attributes.postfix;

		var wrapper = attributes.wrapper;
		var items = attributes.items;

		var blockCssY = attributes.blockCssY;

		var postId = context["postId"];
		var postType = context["postType"];

		var breakPointX = myStore.getBreakPoint();

		const [metaValue, setMetaValue] = useState(null);
		const [metaHtml, setMetaHtml] = useState("");
		const [metaArgs, setMetaArgs] = useState(null);

		// Wrapper CSS Class Selectors
		const wrapperSelector = blockClass;
		const metaValueSelector = blockClass + " .metaValue";
		useEffect(() => {
			var blockIdX = "pg" + clientId.split("-").pop();
			setAttributes({ blockId: blockIdX });

			// setAttributes({ postTitle: postTitle });
			// setAttributes({ wrapper: wrapper });

			myStore.generateBlockCss(blockCssY.items, blockId);
		}, [clientId]);

		useEffect(() => {
			var blockCssObj = {};

			blockCssObj[wrapperSelector] = wrapper;
			blockCssObj[metaValueSelector] = meta;

			var blockCssRules = myStore.getBlockCssRules(blockCssObj);

			var items = blockCssRules;
			setAttributes({ blockCssY: { items: items } });
		}, [blockId]);

		var metaKeyTypeArgsBasic = {
			string: { label: "String", value: "string" },
			object: { label: "Object", value: "object", isPro: true },
			array: { label: "Array", value: "array", isPro: true },

			acfText: { label: "ACF Text", value: "acfText" },
			acfTextarea: { label: "ACF Textarea", value: "acfTextarea" },
			acfNumber: { label: "ACF Number", value: "acfNumber" },
			acfRange: { label: "ACF Range", value: "acfRange" },
			acfEmail: { label: "ACF Email", value: "acfEmail" },
			acfUrl: { label: "ACF URL", value: "acfUrl" },
			acfPassword: { label: "ACF Password", value: "acfPassword" },
			//acfWysiwyg: { label: 'ACF WYSIWYG', value: 'acfWysiwyg', isPro: true },

			acfSelect: { label: "ACF Select", value: "acfSelect", isPro: true },
			acfCheckbox: { label: "ACF Checkbox", value: "acfCheckbox", isPro: true },
			acfRadio: { label: "ACF Radio", value: "acfRadio", isPro: true },

			acfImage: { label: "ACF Image", value: "acfImage", isPro: true },
			acfFile: { label: "ACF File", value: "acfFile", isPro: true },
			acfTaxonomy: { label: "ACF Taxonomy", value: "acfTaxonomy", isPro: true },
			acfPostObject: {
				label: "ACF Post Object",
				value: "acfPostObject",
				isPro: true,
			},
			acfPageLink: {
				label: "ACF Page Link",
				value: "acfPageLink",
				isPro: true,
			},
			acfLink: { label: "ACF Link", value: "acfLink", isPro: true },
			acfUser: { label: "ACF User", value: "acfUser", isPro: true },
			acfButtonGroup: {
				label: "ACF Button Group",
				value: "acfButtonGroup",
				isPro: true,
			},
			// acfBoolen: { label: 'ACF Boolen', value: 'acfBoolen', isPro: true },
			// acfTimePicker: { label: 'ACF TimePicker', value: 'acfTimePicker', isPro: true },
			// acfDatePicker: { label: 'ACF DatePicker', value: 'acfDatePicker', isPro: true },
			// acfDateTimePicker: { label: 'ACF DateTimePicker', value: 'acfDateTimePicker', isPro: true },
			// acfColorPicker: { label: 'ACF ColorPicker', value: 'acfColorPicker', isPro: true },
			// acfGoogleMap: { label: 'ACF Google Map', value: 'acfGoogleMap', isPro: true },
		};

		let metaKeyTypeArgs = applyFilters("metaKeyTypeArgs", metaKeyTypeArgsBasic);

		useEffect(() => {
			apiFetch({
				path: "/post-grid/v2/get_post_meta",
				method: "POST",
				data: {
					postId: postId,
					meta_key: meta.options.key,
					type: meta.options.type,
					template: template,
				},
			}).then((res) => {
				if (res.args == undefined) {
				} else {
					setMetaArgs(res.args);
				}
				if (res.html == undefined) {
				} else {
					setMetaHtml(res.html);
				}

				// if (meta.options.type == 'acfImage') {

				//   setMetaHtml(res.html);
				//   setMetaArgs(res.args);

				// }
				// else if (meta.options.type == 'acfFile') {
				//   setMetaHtml(res.html);
				//   setMetaArgs(res.args);
				// }

				// else {

				//   setMetaHtml(res.html);
				//   setMetaArgs(res.args);
				// }
			});
		}, [meta, template]);

		// useEffect(() => {

		//   if (metaValue != null) {

		//     if (meta.options.type == 'string') {
		//       setMetaValue(res.meta_value)
		//     } else if (meta.options.type == 'acfImage') {

		//       console.log(res.html);

		//       setMetaHtml(res.html);
		//     }

		//   }

		// }, [template]);

		// var breakPointList = [];

		const WrapperTag =
			wrapper.options.tag != undefined && wrapper.options.tag.length != 0
				? `${wrapper.options.tag}`
				: "div";

		const CustomTag =
			wrapper.options.tag != undefined && wrapper.options.tag.length != 0
				? `${wrapper.options.tag}`
				: "div";

		function onPickBlockPatterns(content, action) {
			const { parse } = wp.blockSerializationDefaultParser;

			var blocks = content.length > 0 ? parse(content) : "";
			console.log(content);
			console.log(blocks);
			const attributes = blocks[0].attrs;

			if (action == "insert") {
				wp.data
					.dispatch("core/block-editor")
					.insertBlocks(wp.blocks.parse(content));
			}
			if (action == "applyStyle") {
				var wrapperX = attributes.wrapper;
				var metaX = attributes.meta;
				var prefixX = attributes.prefix;
				var postfixX = attributes.postfix;
				var templateX = attributes.template;
				var templateLoopX = attributes.templateLoop;
				var blockCssYX = attributes.blockCssY;

				var blockCssObj = {};

				if (templateLoopX != undefined) {
					var templateLoopY = {
						...templateLoopX,
						options: templateLoop.options,
					};
					setAttributes({ templateLoop: templateLoopY });
					blockCssObj[templateLoopSelector] = templateLoopY;
				}

				if (templateX != undefined) {
					var templateY = { ...templateX, options: template.options };
					setAttributes({ template: templateY });
					blockCssObj[templateSelector] = templateY;
				}

				if (postfixX != undefined) {
					var postfixY = { ...postfixX, options: postfix.options };
					setAttributes({ postfix: postfixY });
					blockCssObj[postfixSelector] = postfixY;
				}

				if (prefixX != undefined) {
					var prefixY = { ...prefixX, options: prefix.options };
					setAttributes({ prefix: prefixY });
					blockCssObj[prefixSelector] = prefixY;
				}

				if (metaX != undefined) {
					var metaY = { ...metaX, options: meta.options };
					setAttributes({ meta: metaY });
					blockCssObj[metaSelector] = metaY;
				}

				if (wrapperX != undefined) {
					var wrapperY = { ...wrapperX, options: wrapper.options };
					setAttributes({ wrapper: wrapperY });
					blockCssObj[wrapperSelector] = wrapperY;
				}

				var blockCssRules = myStore.getBlockCssRules(blockCssObj);

				var items = blockCssRules;
				setAttributes({ blockCssY: { items: items } });
			}
			if (action == "replace") {
				if (confirm("Do you want to replace?")) {
					wp.data
						.dispatch("core/block-editor")
						.replaceBlock(clientId, wp.blocks.parse(content));
				}
			}
		}

		function onPickCssLibraryWrapper(args) {
			Object.entries(args).map((x) => {
				var sudoScource = x[0];
				var sudoScourceArgs = x[1];
				wrapper[sudoScource] = sudoScourceArgs;
			});

			var wrapperX = Object.assign({}, wrapper);
			setAttributes({ wrapper: wrapperX });

			var styleObj = {};

			Object.entries(args).map((x) => {
				var sudoScource = x[0];
				var sudoScourceArgs = x[1];
				var elementSelector = myStore.getElementSelector(
					sudoScource,
					wrapperSelector
				);

				var sudoObj = {};
				Object.entries(sudoScourceArgs).map((y) => {
					var cssPropty = y[0];
					var cssProptyVal = y[1];
					var cssProptyKey = myStore.cssAttrParse(cssPropty);
					sudoObj[cssProptyKey] = cssProptyVal;
				});

				styleObj[elementSelector] = sudoObj;
			});

			var cssItems = Object.assign(blockCssY.items, styleObj);
			setAttributes({ blockCssY: { items: cssItems } });
		}

		function onPickCssLibraryMeta(args) {
			Object.entries(args).map((x) => {
				var sudoScource = x[0];
				var sudoScourceArgs = x[1];
				meta[sudoScource] = sudoScourceArgs;
			});

			var metaX = Object.assign({}, meta);
			setAttributes({ meta: metaX });

			var styleObj = {};

			Object.entries(args).map((x) => {
				var sudoScource = x[0];
				var sudoScourceArgs = x[1];
				var elementSelector = myStore.getElementSelector(
					sudoScource,
					metaValueSelector
				);

				var sudoObj = {};
				Object.entries(sudoScourceArgs).map((y) => {
					var cssPropty = y[0];
					var cssProptyVal = y[1];
					var cssProptyKey = myStore.cssAttrParse(cssPropty);
					sudoObj[cssProptyKey] = cssProptyVal;
				});

				styleObj[elementSelector] = sudoObj;
			});

			var cssItems = Object.assign(blockCssY.items, styleObj);
			setAttributes({ blockCssY: { items: cssItems } });
		}

		function onChangeStyleWrapper(sudoScource, newVal, attr) {
			var path = [sudoScource, attr, breakPointX];
			let obj = Object.assign({}, wrapper);
			const object = myStore.updatePropertyDeep(obj, path, newVal);

			setAttributes({ wrapper: object });

			var elementSelector = myStore.getElementSelector(
				sudoScource,
				wrapperSelector
			);
			var cssPropty = myStore.cssAttrParse(attr);

			let itemsX = Object.assign({}, blockCssY.items);

			if (itemsX[elementSelector] == undefined) {
				itemsX[elementSelector] = {};
			}

			var cssPath = [elementSelector, cssPropty, breakPointX];
			const cssItems = myStore.updatePropertyDeep(itemsX, cssPath, newVal);

			setAttributes({ blockCssY: { items: cssItems } });

			// var path = sudoScource + '.' + attr + '.' + breakPointX
			// let obj = Object.assign({}, wrapper);
			// const updatedObj = myStore.setPropertyDeep(obj, path, newVal)
			// setAttributes({ wrapper: updatedObj });
			// var sudoScourceX = { ...updatedObj[sudoScource] }

			// var elementSelector = myStore.getElementSelector(sudoScource, wrapperSelector);

			// sudoScourceX[attr][breakPointX] = newVal;

			// if (blockCssY.items[elementSelector] == undefined) {
			//   blockCssY.items[elementSelector] = {};
			// }

			// Object.entries(sudoScourceX).map(args => {
			//   var argAttr = myStore.cssAttrParse(args[0]);
			//   var argAttrVal = args[1];
			//   blockCssY.items[elementSelector][argAttr] = argAttrVal;
			// })

			// setAttributes({ blockCssY: { items: blockCssY.items } });
		}

		function onRemoveStyleWrapper(sudoScource, key) {
			var object = myStore.deletePropertyDeep(wrapper, [
				sudoScource,
				key,
				breakPointX,
			]);
			setAttributes({ wrapper: object });

			var elementSelector = myStore.getElementSelector(
				sudoScource,
				wrapperSelector
			);
			var cssPropty = myStore.cssAttrParse(key);
			var cssObject = myStore.deletePropertyDeep(blockCssY.items, [
				elementSelector,
				cssPropty,
				breakPointX,
			]);
			setAttributes({ blockCssY: { items: cssObject } });

			// var sudoScourceX = { ...wrapper[sudoScource] }
			// if (sudoScourceX[key] != undefined) {
			//   delete sudoScourceX[key];
			// }

			// wrapper[sudoScource] = sudoScourceX;
			// setAttributes({ wrapper: { ...wrapper } });

			// if (blockCssY.items[wrapperSelector] == undefined) {
			//   blockCssY.items[wrapperSelector] = {};
			// }

			// Object.entries(sudoScourceX).map(args => {
			//   var argAttr = myStore.cssAttrParse(args[0]);
			//   var argAttrVal = args[1];
			//   blockCssY.items[wrapperSelector][argAttr] = argAttrVal;
			// })

			// if (blockCssY.items[wrapperSelector][key] != undefined) {
			//   delete blockCssY.items[wrapperSelector][key];
			// }

			// setAttributes({ blockCssY: { items: blockCssY.items } });
		}

		function onAddStyleWrapper(sudoScource, key) {
			// var sudoScourceX = { ...wrapper[sudoScource] }
			// sudoScourceX[key] = {};
			// wrapper[sudoScource] = sudoScourceX;
			// setAttributes({ wrapper: { ...wrapper } });

			var path = [sudoScource, key, breakPointX];
			let obj = Object.assign({}, wrapper);
			const object = myStore.addPropertyDeep(obj, path, "");
			setAttributes({ wrapper: object });
		}

		function onChangeStyleMeta(sudoScource, newVal, attr) {
			var path = [sudoScource, attr, breakPointX];
			let obj = Object.assign({}, meta);
			const object = myStore.updatePropertyDeep(obj, path, newVal);

			setAttributes({ meta: object });

			var elementSelector = myStore.getElementSelector(
				sudoScource,
				metaValueSelector
			);
			var cssPropty = myStore.cssAttrParse(attr);

			let itemsX = Object.assign({}, blockCssY.items);

			if (itemsX[elementSelector] == undefined) {
				itemsX[elementSelector] = {};
			}

			var cssPath = [elementSelector, cssPropty, breakPointX];
			const cssItems = myStore.updatePropertyDeep(itemsX, cssPath, newVal);

			setAttributes({ blockCssY: { items: cssItems } });

			// var path = sudoScource + '.' + attr + '.' + breakPointX
			// let obj = Object.assign({}, meta);
			// const updatedObj = myStore.setPropertyDeep(obj, path, newVal)
			// setAttributes({ meta: updatedObj });
			// var sudoScourceX = { ...updatedObj[sudoScource] }

			// var elementSelector = metaValueSelector;
			// var elementSelector = myStore.getElementSelector(sudoScource, metaValueSelector);

			// sudoScourceX[attr][breakPointX] = newVal;

			// if (blockCssY.items[elementSelector] == undefined) {
			//   blockCssY.items[elementSelector] = {};
			// }

			// Object.entries(sudoScourceX).map(args => {
			//   var argAttr = myStore.cssAttrParse(args[0]);
			//   var argAttrVal = args[1];
			//   blockCssY.items[elementSelector][argAttr] = argAttrVal;
			// })

			// setAttributes({ blockCssY: { items: blockCssY.items } });
			// setAttributes({ meta: { ...meta } });
		}

		function onRemoveStyleMeta(sudoScource, key) {
			var object = myStore.deletePropertyDeep(meta, [
				sudoScource,
				key,
				breakPointX,
			]);
			setAttributes({ meta: object });

			var elementSelector = myStore.getElementSelector(
				sudoScource,
				metaValueSelector
			);
			var cssPropty = myStore.cssAttrParse(key);
			var cssObject = myStore.deletePropertyDeep(blockCssY.items, [
				elementSelector,
				cssPropty,
				breakPointX,
			]);
			setAttributes({ blockCssY: { items: cssObject } });

			// var sudoScourceX = { ...meta[sudoScource] }
			// if (sudoScourceX[key] != undefined) {
			//   delete sudoScourceX[key];
			// }

			// meta[sudoScource] = sudoScourceX;
			// setAttributes({ meta: { ...meta } });

			// if (blockCssY.items[metaValueSelector] == undefined) {
			//   blockCssY.items[metaValueSelector] = {};
			// }

			// Object.entries(sudoScourceX).map(args => {
			//   var argAttr = myStore.cssAttrParse(args[0]);
			//   var argAttrVal = args[1];
			//   blockCssY.items[metaValueSelector][argAttr] = argAttrVal;
			// })

			// if (blockCssY.items[metaValueSelector][key] != undefined) {
			//   delete blockCssY.items[metaValueSelector][key];
			// }

			// setAttributes({ blockCssY: { items: blockCssY.items } });
		}

		function onAddStyleMeta(sudoScource, key) {
			// var sudoScourceX = { ...meta[sudoScource] }
			// sudoScourceX[key] = {};
			// meta[sudoScource] = sudoScourceX;
			// setAttributes({ meta: { ...meta } });

			var path = [sudoScource, key, breakPointX];
			let obj = Object.assign({}, meta);
			const object = myStore.addPropertyDeep(obj, path, "");
			setAttributes({ meta: object });
		}

		function onBulkAddWrapper(sudoScource, cssObj) {
			let obj = Object.assign({}, wrapper);
			obj[sudoScource] = cssObj;

			setAttributes({ wrapper: obj });

			var selector = myStore.getElementSelector(sudoScource, wrapperSelector);
			var stylesObj = {};

			Object.entries(cssObj).map((args) => {
				var attr = args[0];
				var cssPropty = myStore.cssAttrParse(attr);

				if (stylesObj[selector] == undefined) {
					stylesObj[selector] = {};
				}

				if (stylesObj[selector][cssPropty] == undefined) {
					stylesObj[selector][cssPropty] = {};
				}

				stylesObj[selector][cssPropty] = args[1];
			});

			var cssItems = { ...blockCssY.items };
			var cssItemsX = { ...cssItems, ...stylesObj };

			setAttributes({ blockCssY: { items: cssItemsX } });
		}

		function onBulkAddMeta(sudoScource, cssObj) {
			let obj = Object.assign({}, meta);
			obj[sudoScource] = cssObj;

			setAttributes({ meta: obj });

			var selector = myStore.getElementSelector(sudoScource, metaSelector);
			var stylesObj = {};

			Object.entries(cssObj).map((args) => {
				var attr = args[0];
				var cssPropty = myStore.cssAttrParse(attr);

				if (stylesObj[selector] == undefined) {
					stylesObj[selector] = {};
				}

				if (stylesObj[selector][cssPropty] == undefined) {
					stylesObj[selector][cssPropty] = {};
				}

				stylesObj[selector][cssPropty] = args[1];
			});

			var cssItems = { ...blockCssY.items };
			var cssItemsX = { ...cssItems, ...stylesObj };

			setAttributes({ blockCssY: { items: cssItemsX } });
		}

		useEffect(() => {
			myStore.generateBlockCss(blockCssY.items, blockId);
		}, [blockCssY]);

		useEffect(() => {
			myStore.generateBlockCss(blockCssY.items, blockId);
		}, [items]);

		const post = useSelect((select) =>
			select("core").getEntityRecord(
				"postType",
				context["postType"],
				context["postId"]
			)
		);

		const termstaxonomy = useSelect((select) =>
			select("core").getEntityRecords("taxonomy", "category", [4, 5])
		);

		const blockProps = useBlockProps({
			className: ` ${blockId} ${wrapper.options.class}`,
		});

		return (
			<>
				<InspectorControls>
					<div className="pg-setting-input-text">
						<PanelBody
							className="font-medium text-slate-900 "
							title="Wrapper"
							initialOpen={false}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
									{
										name: "css",
										title: "CSS Library",
										icon: mediaAndText,
										className: "tab-css",
									},
								]}>
								<PGtab name="options">
									<PGcssClassPicker
										tags={customTags}
										label="CSS Class"
										placeholder="Add Class"
										value={wrapper.options.class}
										onChange={(newVal) => {
											var options = { ...wrapper.options, class: newVal };
											setAttributes({
												wrapper: { styles: wrapper.styles, options: options },
											});
										}}
									/>

									<PanelRow>
										<label for="" className="font-medium text-slate-900 ">
											CSS ID
										</label>
										<InputControl
											value={blockId}
											onChange={(newVal) => {
												setAttributes({
													blockId: newVal,
												});
											}}
										/>
									</PanelRow>
									<PanelRow>
										<label for="" className="font-medium text-slate-900 ">
											Wrapper Tag
										</label>
										<SelectControl
											label=""
											value={wrapper.options.tag}
											options={[
												{ label: "Choose", value: "" },
												{ label: "H1", value: "h1" },
												{ label: "H2", value: "h2" },
												{ label: "H3", value: "h3" },
												{ label: "H4", value: "h4" },
												{ label: "H5", value: "h5" },
												{ label: "H6", value: "h6" },
												{ label: "SPAN", value: "span" },
												{ label: "DIV", value: "div" },
												{ label: "P", value: "p" },
											]}
											onChange={(newVal) => {
												var options = { ...wrapper.options, tag: newVal };
												setAttributes({
													wrapper: { styles: wrapper.styles, options: options },
												});
											}}
										/>
									</PanelRow>
									<PanelRow>
										<label for="" className="font-medium text-slate-900 ">
											Wrapper Class
										</label>

										<InputControl
											value={wrapper.options.class}
											onChange={(newVal) => {
												var options = { ...wrapper.options, class: newVal };
												setAttributes({
													wrapper: { ...wrapper, options: options },
												});
											}}
										/>
									</PanelRow>
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={wrapper}
										onChange={onChangeStyleWrapper}
										onAdd={onAddStyleWrapper}
										onBulkAdd={onBulkAddWrapper}
										onRemove={onRemoveStyleWrapper}
									/>
								</PGtab>
								<PGtab name="css">
									<PGCssLibrary
										blockId={blockId}
										obj={wrapper}
										onChange={onPickCssLibraryWrapper}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>
						<PanelBody
							className="font-medium text-slate-900 "
							title="Meta Key"
							initialOpen={true}>
							<PGtabs
								activeTab="options"
								orientation="horizontal"
								activeClass="active-tab"
								onSelect={(tabName) => {}}
								tabs={[
									{
										name: "options",
										title: "Options",
										icon: settings,
										className: "tab-settings",
									},
									{
										name: "styles",
										title: "Styles",
										icon: brush,
										className: "tab-style",
									},
									// {
									//   name: 'css',
									//   title: 'CSS Library',
									//   icon: styles,
									//   className: 'tab-css',
									// },
								]}>
								<PGtab name="options">
									<PanelRow>
										<label for="" className="font-medium text-slate-900 ">
											Meta Key
										</label>

										<InputControl
											placeholder="Meta key"
											value={meta.options.key}
											onChange={(newVal) => {
												var options = { ...meta.options, key: newVal };
												setAttributes({ meta: { ...meta, options: options } });
											}}
										/>
									</PanelRow>

									<PanelRow>
										<label>Meta Key Type </label>
										<PGDropdown
											position="bottom right"
											variant="secondary"
											options={metaKeyTypeArgs}
											buttonTitle="Choose"
											onChange={(option, index) => {
												var options = { ...meta.options, type: option.value };
												setAttributes({ meta: { ...meta, options: options } });
											}}
											values=""
											value={meta.options.type}></PGDropdown>
									</PanelRow>

									<label className="my-3" for="">
										Template
									</label>

									<TextareaControl
										value={template}
										onChange={(newVal) => {
											setAttributes({ template: newVal });
										}}
									/>

									<p>
										You can use following <code>&#123;metaValue&#125;</code> to
										display output
									</p>

									{meta.options.type != "string" && (
										<>
											<div className="hidden">
												<label className="mt-5 block" for="">
													Loop Template{" "}
												</label>
												<TextareaControl
													placeholder="<div>{title}</div><div>{details}</div>"
													value={templateLoop}
													onChange={(newVal) => {
														setAttributes({ templateLoop: newVal });
													}}
												/>

												<p>
													You can use following for loop template to iterate
													array elements{" "}
													<code>
														&#60;div&#62;
														&#123;itemIndex1&#125;&#60;/div&#62;&#60;div&#62;&#123;itemIndex2&#125;&#60;/div&#62;
													</code>
												</p>
											</div>
											<div className="my-3">
												<label for="" className="font-medium text-slate-900 ">
													Parameters
												</label>
												<div className="">
													{metaArgs != undefined &&
														Object.entries(metaArgs).map((arg, i) => {
															var key = arg[0];
															var val = arg[1];

															return (
																<div className="my-2 bg-gray-300">
																	<div
																		onClick={(ev) => {
																			var target = ev.target;
																		}}
																		className="bg-gray-500 px-3 py-2 text-white">
																		{key}
																	</div>
																	<div className="px-3 py-2">{val}</div>
																</div>
															);
														})}
												</div>
											</div>
										</>
									)}
								</PGtab>
								<PGtab name="styles">
									<PGStyles
										obj={meta}
										onChange={onChangeStyleMeta}
										onAdd={onAddStyleMeta}
										onBulkAdd={onBulkAddMeta}
										onRemove={onRemoveStyleMeta}
									/>
								</PGtab>
								<PGtab name="css">
									<PGCssLibrary
										blockId={blockId}
										obj={meta}
										onChange={onPickCssLibraryMeta}
									/>
								</PGtab>
							</PGtabs>
						</PanelBody>

						<PanelBody
							className="font-medium text-slate-900 "
							title="Block Variations"
							initialOpen={false}>
							<PGLibraryBlockVariations
								blockName={"post-meta"}
								blockId={blockId}
								clientId={clientId}
								onChange={onPickBlockPatterns}
							/>
						</PanelBody>
					</div>
				</InspectorControls>

				<>
					{meta.options.key.length == 0 && (
						<div {...blockProps}>
							<div className="bg-slate-300 p-10 ">
								<div className="w-[400px] mx-auto my-0">
									<label
										for=""
										className="font-medium text-slate-900 my-4 block">
										Meta Field Key
									</label>
									<InputControl
										placeholder="Write Meta key"
										value={meta.options.key}
										onChange={(newVal) => {
											var options = { ...meta.options, key: newVal };
											setAttributes({ meta: { ...meta, options: options } });
										}}
									/>
								</div>
							</div>
						</div>
					)}

					{meta.options.key.length != 0 && (
						<WrapperTag
							{...blockProps}
							dangerouslySetInnerHTML={{ __html: metaHtml }}
						/>
					)}
				</>
			</>
		);
	},
	save: function (props) {
		// to make a truly dynamic block, we're handling front end by render_callback under index.php file
		return null;
	},
});
