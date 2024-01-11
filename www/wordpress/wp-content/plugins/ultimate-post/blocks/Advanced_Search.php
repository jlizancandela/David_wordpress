<?php
namespace ULTP\blocks;

defined('ABSPATH') || exit;

class Advanced_Search{
    public function __construct() {
        add_action('init', array($this, 'register'));
    }

    public function get_attributes() {
        return array(
            'advanceId' => '',
            'blockId' => '',
            'advanceCss' => '',

            /* =================================  
                General Content Setting
            ================================= */  
            'searchFormStyle' => 'input1',
            'searchPopup' => false,
            'searchPopupIconStyle' => 'popup-icon1',
            'searchAjaxEnable' => true,
            'searchResultLayout' => 'res',
            'searchnoresult' => 'No Results Found',
            'noresultColor' => '#000',
            'popupIconTextTypo' => (object)['openTypography' => 1,'size' => (object)['lg' =>16, 'unit' =>'px'],'height' => (object)['lg' =>20, 'unit' =>'px']],
            'searchPostType' => '',
            /* =================================  
                Popup Icon Style
            ================================= */  
            'popupIconGap' => (object)['lg' =>'17', 'unit' =>'px'],
            'popupIconSize' => (object)['lg' =>'17', 'unit' =>'px'],
            'popupIconTextTypo' => (object)['openTypography' => 1,'size' => (object)['lg' =>16, 'unit' =>'px'],'height' => (object)['lg' =>20, 'unit' =>'px']],
            'popupIconColor' => '#000',
            'popupIconBg' => (object)['openColor' => 0, 'type' => 'color', 'color' => '#f5f5f5'],
            'popupIconHoverBg' =>(object)['openColor' => 0, 'type' => 'color', 'color' => '#f5f5f5'],
            'popupIconTextColor' =>  '',
            'popupIconHoverColor' =>  '',
            'popupIconTextHoverColor' =>  '',

            /* =================================  
                Popup Canvas
            ================================= */  
            'popupAnimation' =>  'popup',
            'popupCloseSize' =>  (object)['lg' =>'20', 'unit' =>'px'],
            'popupCloseColor' =>  '#000',
            //
            'popupCloseHoverColor' => '#7777',
            'windowpopupHeadingTypo' => (object)['openTypography' => 1,'size' => (object)['lg' => 16, 'unit' =>'px'],'height' => (object)['lg' => 24, 'unit' =>'px'], 'weight' => '600'],
            'windowpopupHeadingColor' => '#000',
            'searchPopupPosition' => 'right',
            'popupCloseIconSeparator' => 'Close Icon Style',
            'windowpopupHeading' => true,
            'windowpopupText' => 'Search The Query',
            'windowpopupHeadingAlignment' => 'center',
            'popupHeadingSpacing' => (object)['lg' =>'12'],
            'popupBG' => (object)['openColor' => 1, 'type' => 'color', 'color' => '#FCFCFC'], 
            'canvasWidth' => (object)['lg' =>'600', 'xs' => '100', 'ulg' => 'px', 'unit' =>'%'], 
            'popupPadding' => (object)['lg' =>(object)['top' => '40','bottom' => '40','left' => '40', 'right' => '40', 'unit' =>'px']], 
            'popupRadius' => (object)['lg' =>(object)['top' => '20','bottom' => '20','left' => '20', 'right' => '20', 'unit' =>'px'], 
            'popupShadow' => (object)['openShadow' => 1, 'width' => (object)['top' => 0, 'right' => 3, 'bottom' => 6, 'left' => 0],'color' => 'rgba(0, 0, 0, 0.16)']], 
            // 'popupPositionX' => (object)['lg' =>'', 'unit' =>'px'], 
            'popupPositionY' => (object)['lg' =>'10', 'unit' =>'px'],

            /* =================================  
                Search Button Style
            ================================= */  
            'searchBtnEnable' => false,
            'btnNewTab' => false,
            'enableSearchPage' => true,
            'searchButtonText' => 'Search',
            'searchBtnText' => true,
            'searchBtnIcon' => true,
            'searchIconAfterText' => false,
            'searchButtonPosition' => (object)['lg' =>'7', 'unit' =>'px'],
            'searchTextGap' => (object)['lg' =>'8', 'unit' =>'px'],
            'searchBtnIconSize' => (object)['lg' =>'17', 'unit' =>'px'],
            'searchBtnTextTypo' => (object)['openTypography' => 1,'size' => (object)['lg' =>14, 'unit' =>'px'],'height' => (object)['lg' =>22, 'unit' =>'px']],
            'searchBtnIconColor' => '#fff',
            'searchBtnTextColor' => '#fff',
            'searchBtnBg' => (object)['openColor' => 1, 'type' => 'color', 'color' => '#212121'],
            // 'searchBtnIconHoverColor' => '',
            // 'searchBtnTextHoverColor' => '',
            // 'searchBtnHoverBg' => '',
            'searchBtnRadius' => (object)['lg' =>(object)['top' => '13','bottom' => '13','left' => '13', 'right' => '13', 'unit' =>'px']],
            // 'searchBtnHoverRadius' => '',

            /* =================================  
                    Search Form Style
            ================================= */  
            'searchBtnReverse' => false,
            'searchInputPlaceholder' => 'Search...',
            // 'inputTypo' => (object)['openTypography' => 1,'size' => (object)['lg' =>14, 'unit' =>'px'],'height' => (object)['lg' =>22, 'unit' =>'px']],
            // 'inputHeight' => (object)['lg' =>'17', 'unit' =>'px'],
            'inputColor' => '#000',
            // 'inputBg' => (object)['openColor' => 1, 'type' => 'color', 'color' => '#212121'],
            'searchFormWidth' => (object)['lg' =>'', 'sm' => '100', 'ulg' => 'px', 'unit' =>'%'], 
            'inputFocusBorder' => (object)['openBorder'=>0, 'width' => (object)['top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1],'color' => '#000','type' => 'solid'],
            'inputBorder' => (object)['openBorder'=>0, 'width' => (object)['top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1],'color' => '#989898','type' => 'solid'],
            // 'inputPadding' => '',
            // 'inputRadius' => '',
            // 'inputOuterPadding' => '',
            // 'inputOuterRadius' => '',
            // 'inputOuterBg' => '',

            /* =================================  
                    Search Result Settings
            ================================= */  
            'resColumn' => (object)['lg' =>'1'],
            'resExcerptEnable' => true,
            'resCatEnable' => true,
            'resAuthEnable' => true,
            'resDateEnable' => true,
            'resImageEnable' => true,
            'resImageSize' => (object)['lg' =>'70', 'unit' =>'px'],
            'resImageRadius' => (object)['lg' =>(object)['top' => '0','bottom' => '0','left' => '0', 'right' => '0', 'unit' =>'px']],
            'resImageSpace' => (object)['lg' =>'20', 'unit' =>'px'],
            // 'resMetaEnable' => '',
            // 'resTitleEnable' => '',
            'resTitleColor' => '#101010',
            'resExcerptColor' => '#000',
            'resCatColor' => '#000',
            'resAuthorColor' => '#101010',
            'resDateColor' => '#6e6e6e',
            'resTitleHoverColor' => '#037fff',
            'resAuthorHovertColor' => '#037fff',
            'resTitleTypo' => (object)['openTypography' => 1,'size' => (object)['lg' =>14, 'unit' =>'px'],'height' => (object)['lg' =>23, 'unit' =>'px']],
            'excerptTypo' => (object)['openTypography' => 1,'size' => (object)['lg' =>14, 'unit' =>'px'],'height' => (object)['lg' =>23, 'unit' =>'px']],
            'resMetaTypo' => (object)['openTypography' => 1,'size' => (object)['lg' =>12, 'unit' =>'px'],'height' => (object)['lg' =>22, 'unit' =>'px']],
            'resExcerptLimit' => '25',
            'resultMetaSpace' => (object)['lg' =>'8', 'unit' =>'px'],
            'resultMetaSeparatorSize' => (object)['lg' =>'5', 'unit' =>'px'],
            'resMetaSeparatorColor' => '#4A4A4A',
            // 'resultBg' => (object)['openColor' => 0, 'type' => 'color', 'color' => '#f5f5f5'],
            'resultWidth' => (object)['lg' =>'100', 'unit' =>'%'],
            'resultMaxHeight' => (object)['lg' =>'300', 'unit' =>'px'],
            'resultPadding' => (object)['lg' =>(object)['top' => '15','bottom' => '15','left' => '15', 'right' => '15', 'unit' =>'px']],
            // 'resultBorder' => '',
            // 'resultBorderRadius' => '',
            // 'resultShadow' => '',
            'resultSpacingX' => (object)['lg' =>'0', 'unit' =>'px'],
            'resultSpacingY' => (object)['lg' =>'0', 'unit' =>'px'],
            'resultSeparatorColor' => '#DEDEDE',
            'resultSeparatorWidth' => (object)['lg' =>'1', 'unit' =>'px'],
            // 'resultSeparatorSpace' => '',

            /* =================================  
                    Search Result Settings
            ================================= */  
            'moreResultsbtn' => true,
            'moreResultPosts' => 3,
            'moreResultsText' => 'View More Results',
            'moreResultsTypo' => (object)['openTypography' => 1,'size' => (object)['lg' =>14, 'unit' =>'px'],'height' => (object)['lg' =>23, 'unit' =>'px']],
            'moreResultsColor' => '#646464',
            'moreResultsHoverColor' => '#000'
        );
    }

    public function register() {
        register_block_type( 'ultimate-post/advanced-search',
            array(
                'editor_script' => 'ultp-blocks-editor-script',
                'editor_style'  => 'ultp-blocks-editor-css',
                'render_callback' =>  array($this, 'content')
            )
        );
    }

    public function content($attr, $noAjax) {
        $wraper_before = $wraper_after = $content = $popup_content = '';
        $block_name = 'advanced-search';
        $is_active = ultimate_post()->is_lc_active(); 
        if($is_active){
            $attr = wp_parse_args($attr, $this->get_attributes());

            $data_var = "data-searchPostType=".json_decode(json_encode($attr['searchPostType']));
            $wraper_before .= '<div '.($attr['advanceId']?'id="'.$attr['advanceId'].'" ':'').' class="wp-block-ultimate-post-'.$block_name.' ultp-block-'.$attr["blockId"].''.(isset($attr["align"])? ' align' .$attr["align"]:'').''.(isset($attr["className"])?' '.$attr["className"]:'').'">';
                $wraper_before .= '<div class="ultp-block-wrapper">';
                    $content .= '<div class="ultp-search-container ultp-search-frontend'.($attr['searchPopup'] ? ' ultp-search-animation-'.$attr['popupAnimation'] :'').'"  data-ajax="'.$attr['searchAjaxEnable'].'" data-gosearch="'.$attr['enableSearchPage'].'" data-enablenewtab="'.$attr['btnNewTab'].'" data-blockId="'.$attr['blockId'].'" 
                    data-image="'.$attr['resImageEnable'].'"  data-author='.$attr['resAuthEnable'].' data-date="'.$attr['resDateEnable'].'" data-excerpt="'.$attr['resExcerptEnable'].'" data-excerptLimit="'.$attr['resExcerptLimit'].'" data-allresult="'.$attr['moreResultsbtn'].'" data-catEnable="'.$attr['resCatEnable'].'"  data-postno="'.$attr['moreResultPosts'].'" '.($attr['searchPopup'] ? 'data-popuptype="'.$attr['popupAnimation'].'" ' : '').' '.($attr['searchAjaxEnable'] ? 'data-noresultext="'.$attr['searchnoresult'].'" ' : '').' '.($attr['moreResultsbtn'] ? 'data-viewmoretext="'.$attr['moreResultsText'].'" ' : '').' data-popupposition="'.$attr['searchPopupPosition'].'" '.$data_var.'>';
                        if($attr['searchPopup'] ){
                            $content .= $this->renderSearchButton($attr['searchPopupIconStyle'], $attr['searchBtnText'], $attr['searchBtnIcon'] ,$attr['searchButtonText']);
                        }
                        if(($attr['searchPopup']) == false) {
                            $content .= $this->renderSearchForm($attr['searchFormStyle'], $attr['searchBtnText'], $attr['searchBtnIcon'], $attr);
                        }
                        if(($attr['searchPopup'])) {
                            $popup_content .= '<div class="ultp-search-canvas">';
                            
                                $popup_content .= '<div class="ultp-canvas-header">';
                                    if($attr['windowpopupHeading']){
                                        $popup_content .= '<div class="ultp-search-popup-heading">'.$attr['windowpopupText'].'</div>';
                                    }
                                    $popup_content .= $this->renderSearchForm($attr['searchFormStyle'], $attr['searchBtnText'], $attr['searchBtnIcon'], $attr);
                                $popup_content .= '</div>';
                                $popup_content .= '<div class="ultp-popupclose-icon">'.ultimate_post()->svg_icon('close_line').'</div>';
                            $popup_content .= '</div>';
                            if($attr['popupAnimation'] == 'popup'){
                                $content .= $popup_content;
                            } else {
                                $content .= $popup_content;
                            }
                        }
                    $content .= '</div>'; 
                $wraper_after .= '</div>';
            $wraper_after .= '</div>';
            return $wraper_before.$content.$wraper_after;
        }
    }

    public function renderSearchButton($style, $textEnable = true, $iconEnable = true, $searchButtonText = '') {
        $textShow = $textEnable && $style != "popup-icon1";
        $result = '';
        $result .= '<div class=" '.($style ? 'ultp-searchpopup-icon ultp-searchbtn-'.$style : 'ultp-search-button').'">';
        $result .= ($style || $iconEnable) ? ultimate_post()->svg_icon('search_line') : '';
        $result .= $textShow ? '<span class="ultp-search-button__text"> '.$searchButtonText.' </span>' : '';
        $result .= '</div>';
        return $result;
    }
    public function renderSearchForm($searchFormStyle, $searchBtnText, $searchBtnIcon, $attr) {

        $dt = is_search() ? get_search_query(true) : '';
        $searchForm = '';
        $searchForm .= '<div class="ultp-searchform-content ultp-searchform-'.$searchFormStyle.'">';
        $searchForm .= '<div class="ultp-search-inputwrap"> <input type="text" value="'.$dt.'" class="ultp-searchres-input"  placeholder="'.$attr['searchInputPlaceholder'].'"/> <span class="ultp-search-clear" data-blockid="'.$attr["blockId"].'">'.ultimate_post()->svg_icon('close_line').'</span> </div>';
            $searchForm .= $this->renderSearchButton(false, $attr['searchBtnText'], $attr['searchBtnIcon'] ,$attr['searchButtonText']);
        $searchForm .= '</div>';
        return $searchForm;
    }
}