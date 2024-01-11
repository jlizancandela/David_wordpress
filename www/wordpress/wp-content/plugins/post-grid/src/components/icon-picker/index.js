

const { Component, RawHTML } = wp.element;
import { Panel, PanelRow, PanelItem, Button, Dropdown, SelectControl, Popover } from '@wordpress/components'
import { createElement, useCallback, memo, useMemo, useState, useEffect } from '@wordpress/element'

import { __experimentalInputControl as InputControl } from '@wordpress/components';
import { link, linkOff } from "@wordpress/icons";

import fontawesomeClasses from './fontawesome-classes'
import iconfontClasses from './iconfont-classes'
import bootstrapIcons from './bootstrap-icons'



function Html(props) {
  if (!props.warn) {
    return null;
  }


  var library = props.library;
  var srcType = props.srcType;
  var iconSrc = props.iconSrc;


  const [iconsArr, setIconsArr] = useState(fontawesomeClasses);



  const [pickerOpen, setPickerOpen] = useState(false);
  const [iconData, setIconData] = useState({ keyword: '', library: library, filtered: [] });
  const [filteredIcons, setFilteredIcons] = useState([]);




  useEffect(() => {


    if (iconData.library == 'fontAwesome') {
      setIconsArr(fontawesomeClasses);
    }

    if (iconData.library == 'iconFont') {
      setIconsArr(iconfontClasses);
    }
    if (iconData.library == 'bootstrap') {
      setIconsArr(bootstrapIcons);
    }



  }, [iconData]);





  return (

    <div className='relative'>
      <div className='border border-gray-500' onClick={ev => {

        setPickerOpen(prev => !prev);

      }}>

        {iconSrc.length == 0 && (

          <Button icon={link}></Button>

        )}

        {iconSrc.length > 0 && (

          <div className='w-8 h-8 text-lg border cursor-pointer hover:bg-gray-200 border-gray-500 text-center'><span className={iconSrc}></span></div>

        )}


      </div>
      {pickerOpen && (
        <Popover position="bottom right">
          <div className='w-72 p-2'>

            <PanelRow>
              <SelectControl
                label=""
                value={iconData.library}
                options={[

                  { label: 'Choose Library', value: '' },
                  { label: 'Font Awesome', value: 'fontAwesome' },
                  { label: 'IconFont', value: 'iconFont' },
                  { label: 'Bootstrap Icons', value: 'bootstrap' },
                  // { label: 'Material', value: 'material' },


                ]}
                onChange={(newVal) => {

                  setIconData({ ...iconData, library: newVal });
                  props.onChange({ iconSrc: iconSrc, library: newVal, srcType: srcType });
                }

                }
              />


              <InputControl

                placeholder="Search for icons"
                value={iconData.keyword}
                onChange={(newVal) => {

                  setIconData({ ...iconData, keyword: newVal });

                  setFilteredIcons([]);

                  var icons = []

                  iconsArr.map(icon => {

                    if (icon.indexOf(newVal) > 0) {
                      icons.push(icon);
                    }

                  })

                  setFilteredIcons(icons);

                }
                }
              />


            </PanelRow>

            <div>

              {iconData.keyword.length == 0 && iconsArr.map(icon => {

                return (

                  <div onClick={ev => {

                    props.onChange({ iconSrc: icon, library: library, srcType: srcType });

                  }} className='m-1 text-lg w-10 text-center cursor-pointer hover:bg-slate-400 p-2 inline-block'><span className={icon}></span></div>

                )

              })}

              {iconData.keyword.length > 0 && filteredIcons.map(icon => {

                return (

                  <div onClick={ev => {

                    props.onChange({ iconSrc: icon, library: library, srcType: srcType });

                  }} className='m-1 text-lg w-10 text-center cursor-pointer hover:bg-slate-400 p-2 inline-block'><span className={icon}></span></div>

                )

              })}


              {filteredIcons.length == 0 && (

                <div className='text-center p-2 text-red-500 '>No icons found.</div>

              )}


            </div>

          </div>






        </Popover>
      )}

    </div>

  )









}


class PGIconPicker extends Component {


  constructor(props) {
    super(props);
    this.state = { showWarning: true };
    this.handleToggleClick = this.handleToggleClick.bind(this);
  }

  handleToggleClick() {
    this.setState(state => ({
      showWarning: !state.showWarning
    }));
  }




  render() {

    var {
      library,
      srcType,
      iconSrc,
      onChange,

    } = this.props;





    return (
      <div>

        <Html library={library} srcType={srcType} iconSrc={iconSrc} onChange={onChange} warn={this.state.showWarning} />


      </div >

    )
  }
}


export default PGIconPicker;