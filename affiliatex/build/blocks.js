var affiliatexExports;(()=>{"use strict";const e=window.wp.richText,t=window.wp.blockEditor,i=window.wp.data,l=window.ReactJSXRuntime,{Toolbar:n,IconButton:a}=wp.components;(0,e.registerFormatType)("affiliatex/tick-icon",{title:"Tick",tagName:"tick",className:null,edit:function(o){const s=(0,i.useSelect)((e=>e("core/block-editor").getSelectedBlock()),[]);return s&&"affiliatex/versus-line"!==s.name&&s&&"affiliatex/versus"!==s.name&&s&&"affiliatex/product-comparison"!==s.name?null:(0,l.jsx)(t.BlockControls,{children:(0,l.jsx)(n,{children:(0,l.jsx)(a,{icon:"yes",title:"Tick",onClick:()=>{let t=(0,e.create)({html:'<i class="fas fa-check" aria-hidden="true"> </i>'});o.onChange((0,e.insert)(o.value,t))},isActive:o.isActive})})})}}),(0,e.registerFormatType)("affiliatex/check-icon",{title:"Check",tagName:"check",className:null,edit:function(o){const s=(0,i.useSelect)((e=>e("core/block-editor").getSelectedBlock()),[]);return s&&"affiliatex/versus-line"!==s.name&&s&&"affiliatex/versus"!==s.name&&s&&"affiliatex/product-comparison"!==s.name?null:(0,l.jsx)(t.BlockControls,{children:(0,l.jsx)(n,{children:(0,l.jsx)(a,{icon:"yes-alt",title:"Check",onClick:()=>{let t=(0,e.create)({html:'<i class="fas fa-check-circle" aria-hidden="true"> </i>'});o.onChange((0,e.insert)(o.value,t))},isActive:o.isActive})})})}}),(0,e.registerFormatType)("affiliatex/wrong-icon",{title:"Wrong",tagName:"wrong",className:null,edit:function(o){const s=(0,i.useSelect)((e=>e("core/block-editor").getSelectedBlock()),[]);return s&&"affiliatex/versus-line"!==s.name&&s&&"affiliatex/versus"!==s.name&&s&&"affiliatex/product-comparison"!==s.name?null:(0,l.jsx)(t.BlockControls,{children:(0,l.jsx)(n,{children:(0,l.jsx)(a,{icon:"no-alt",title:"Wrong",onClick:()=>{let t=(0,e.create)({html:'<i class="fas fa-times" aria-hidden="true"> </i>'});o.onChange((0,e.insert)(o.value,t))},isActive:o.isActive})})})}}),(0,e.registerFormatType)("affiliatex/cross-icon",{title:"Cross",tagName:"cross",className:null,edit:function(o){const s=(0,i.useSelect)((e=>e("core/block-editor").getSelectedBlock()),[]);return s&&"affiliatex/versus-line"!==s.name&&s&&"affiliatex/versus"!==s.name&&s&&"affiliatex/product-comparison"!==s.name?null:(0,l.jsx)(t.BlockControls,{children:(0,l.jsx)(n,{children:(0,l.jsx)(a,{icon:"dismiss",title:"Cross",onClick:()=>{let t=(0,e.create)({html:'<i class="fas fa-times-circle" aria-hidden="true"> </i>'});o.onChange((0,e.insert)(o.value,t))},isActive:o.isActive})})})}}),window.React;const o=window.wp.i18n,s=window.wp.components,r=()=>(0,l.jsxs)("svg",{className:"affx-amazon-icon",width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,l.jsx)("path",{d:"M12.4848 8.63544C11.4449 8.72448 10.4057 8.82624 9.40033 9.12672C7.33801 9.74448 6.28537 11.1396 6.31921 13.1993C6.34993 15.0554 7.42345 16.2869 9.26761 16.4834C10.4563 16.6099 11.5975 16.4131 12.5623 15.6233C12.8386 15.3974 13.0975 15.1502 13.3421 14.9333C13.7417 15.3744 14.1171 15.8131 14.5195 16.2262C14.7747 16.4878 15.0207 16.4774 15.295 16.2425C15.8095 15.8028 16.321 15.3593 16.8327 14.916C17.1091 14.676 17.1451 14.4626 16.897 14.1818C16.29 13.4938 16.08 12.7034 16.0961 11.7926C16.1244 10.1698 16.1115 8.54645 16.0575 6.92424C16.0164 5.67696 15.3931 4.7484 14.2445 4.24008C12.4805 3.46008 10.693 3.47736 8.93401 4.25232C7.74625 4.77648 7.01953 5.71056 6.73561 6.9828C6.64249 7.40088 6.75385 7.55688 7.17481 7.60728C7.78177 7.68 8.38801 7.75776 8.99425 7.83696C9.32857 7.88064 9.51457 7.78032 9.58705 7.44552C9.80281 6.44856 10.7883 5.95536 11.7226 6.09408C12.3257 6.1836 12.7755 6.5652 12.8676 7.14312C12.9425 7.61328 12.937 8.09664 12.9667 8.56896C12.8873 8.59056 12.8573 8.60376 12.8261 8.6064C12.7123 8.61768 12.5986 8.6256 12.4848 8.63544ZM12.4404 13.3807C12.1375 13.8382 11.7495 14.1682 11.2032 14.2601C10.3181 14.4086 9.66697 13.8391 9.60193 12.883C9.51673 11.6309 10.1561 10.7731 11.3921 10.5355C11.8906 10.4395 12.4032 10.4165 12.9334 10.3574C12.9384 11.4386 13.0469 12.4639 12.4404 13.3807Z",fill:"black"}),(0,l.jsx)("path",{d:"M18.0912 17.0141C18.0055 17.0395 17.9237 17.077 17.8411 17.112C16.6618 17.615 15.4493 18.0115 14.19 18.2599C13.001 18.4949 11.8039 18.6134 10.5924 18.5014C9.1032 18.3646 7.71408 17.8855 6.38592 17.2236C5.54064 16.8026 4.71504 16.3423 3.87864 15.9031C3.61632 15.7654 3.37584 15.8062 3.2412 15.997C3.10824 16.1849 3.15432 16.4323 3.38904 16.6171C4.22136 17.2721 5.03184 17.9597 5.90376 18.5578C7.52928 19.6726 9.32136 20.3381 11.6592 20.3371C13.5586 20.2894 15.6475 19.7105 17.5812 18.5854C17.9254 18.3852 18.2551 18.157 18.5767 17.9215C18.8218 17.742 18.8743 17.478 18.749 17.2522C18.6281 17.0338 18.3602 16.9344 18.0912 17.0141Z",fill:"#FF9900"}),(0,l.jsx)("path",{d:"M19.8876 15.1747C18.9684 15.0818 18.0806 15.1934 17.3049 15.761C17.1247 15.8923 17.0203 16.0699 17.1187 16.2898C17.2125 16.4993 17.4043 16.5264 17.6172 16.4964C18.0199 16.4398 18.4243 16.3937 18.8282 16.343L18.8311 16.3745C18.978 16.3745 19.1246 16.3726 19.271 16.375C19.4407 16.3778 19.5312 16.4518 19.4921 16.6342C19.4491 16.8329 19.4201 17.0359 19.3601 17.2291C19.2446 17.6023 19.0953 17.9654 18.9955 18.342C18.9641 18.4606 19.0029 18.6598 19.0869 18.731C19.1827 18.8117 19.3689 18.823 19.5079 18.8042C19.6058 18.7915 19.7013 18.6898 19.7791 18.6096C20.3988 17.9683 20.7146 17.1833 20.8087 16.3114C20.9011 15.4546 20.7492 15.2618 19.8876 15.1747Z",fill:"#FF9900"})]}),c=()=>(0,l.jsx)("svg",{xmlns:"http://www.w3.org/2000/svg",className:"affx-lock-icon",width:"10",height:"10",viewBox:"0 0 26 26",children:(0,l.jsx)("g",{fill:"#0034ff",fillRule:"nonzero",children:(0,l.jsx)("path",{d:"M16,0c-2.21094,0 -4.12109,0.91797 -5.3125,2.40625c-1.19141,1.48828 -1.6875,3.41797 -1.6875,5.5v1.09375h3v-1.09375c0,-1.57812 0.39063,-2.82031 1.03125,-3.625c0.64063,-0.80469 1.51172,-1.28125 2.96875,-1.28125c1.46094,0 2.32813,0.44922 2.96875,1.25c0.64063,0.80078 1.03125,2.05859 1.03125,3.65625v1.09375h3v-1.09375c0,-2.09375 -0.52734,-4.04297 -1.71875,-5.53125c-1.19141,-1.48828 -3.07422,-2.375 -5.28125,-2.375zM9,10c-1.65625,0 -3,1.34375 -3,3v10c0,1.65625 1.34375,3 3,3h14c1.65625,0 3,-1.34375 3,-3v-10c0,-1.65625 -1.34375,-3 -3,-3zM16,15c1.10547,0 2,0.89453 2,2c0,0.73828 -0.40234,1.37109 -1,1.71875v2.28125c0,0.55078 -0.44922,1 -1,1c-0.55078,0 -1,-0.44922 -1,-1v-2.28125c-0.59766,-0.34766 -1,-0.98047 -1,-1.71875c0,-1.10547 0.89453,-2 2,-2z"})})}),d=()=>(0,l.jsx)("svg",{className:"affx-swap-icon",width:"10",height:"10",viewBox:"0 0 448 512",children:(0,l.jsx)("path",{fill:"#0034ff",d:"M438.6 150.6c12.5-12.5 12.5-32.8 0-45.3l-96-96c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.7 96 32 96C14.3 96 0 110.3 0 128s14.3 32 32 32l306.7 0-41.4 41.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l96-96zm-333.3 352c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 416 416 416c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0 41.4-41.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-96 96c-12.5 12.5-12.5 32.8 0 45.3l96 96z"})}),C=()=>(0,l.jsx)("svg",{width:"14",height:"14",viewBox:"0 0 16 16",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,l.jsx)("path",{d:"M7 12V3.85L4.4 6.45L3 5L8 0L13 5L11.6 6.45L9 3.85V12H7ZM2 16C1.45 16 0.979333 15.8043 0.588 15.413C0.196666 15.0217 0.000666667 14.5507 0 14V11H2V14H14V11H16V14C16 14.55 15.8043 15.021 15.413 15.413C15.0217 15.805 14.5507 16.0007 14 16H2Z",fill:"white"})}),u=()=>(0,l.jsxs)("svg",{width:"14",height:"14",viewBox:"0 0 20 20",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,l.jsx)("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M0 9.66687C0 8.5623 0.89543 7.66687 2 7.66687L17.3335 7.66687C18.4381 7.66687 19.3335 8.5623 19.3335 9.66687C19.3335 10.7714 18.4381 11.6669 17.3335 11.6669L2 11.6669C0.89543 11.6669 0 10.7714 0 9.66687Z",fill:"white"}),(0,l.jsx)("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M9.66663 0C10.7712 0 11.6666 0.89543 11.6666 2V17.3335C11.6666 18.4381 10.7712 19.3335 9.66663 19.3335C8.56206 19.3335 7.66663 18.4381 7.66663 17.3335L7.66663 2C7.66663 0.89543 8.56206 0 9.66663 0Z",fill:"white"})]}),f=()=>(0,l.jsxs)("svg",{width:"16",height:"16",viewBox:"0 0 21 21",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:[(0,l.jsx)("path",{d:"M7 12L3 16M3 16L7 20M3 16H19M15 10L19 6M19 6L15 2M19 6L3 6",stroke:"white","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"}),(0,l.jsx)("path",{d:"M7 12L3 16M3 16L7 20M3 16H19M15 10L19 6M19 6L15 2M19 6L3 6",stroke:"white","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"})]}),p=()=>(0,l.jsx)("svg",{width:"12",height:"15",viewBox:"0 0 12 16",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,l.jsx)("path",{d:"M12 0.888889H9L8.14286 0H3.85714L3 0.888889H0V2.66667H12M0.857143 14.2222C0.857143 14.6937 1.03775 15.1459 1.35925 15.4793C1.68074 15.8127 2.11677 16 2.57143 16H9.42857C9.88323 16 10.3193 15.8127 10.6408 15.4793C10.9622 15.1459 11.1429 14.6937 11.1429 14.2222V3.55556H0.857143V14.2222Z",fill:"#E65A5A"})}),x=()=>(0,l.jsx)("svg",{width:"14",height:"10",viewBox:"0 0 16 10",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,l.jsx)("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M6.94 0.939992C7.22125 0.659092 7.6025 0.501312 8 0.501312C8.3975 0.501312 8.77875 0.659092 9.06 0.939992L14.718 6.59599C14.8573 6.73532 14.9677 6.90072 15.0431 7.08275C15.1184 7.26477 15.1572 7.45985 15.1571 7.65685C15.1571 7.85385 15.1182 8.04891 15.0428 8.23089C14.9674 8.41288 14.8568 8.57823 14.7175 8.71749C14.5782 8.85676 14.4128 8.96722 14.2307 9.04256C14.0487 9.11791 13.8536 9.15667 13.6566 9.15662C13.4596 9.15657 13.2646 9.11772 13.0826 9.04229C12.9006 8.96686 12.7353 8.85633 12.596 8.71699L8 4.12199L3.404 8.71799C3.2657 8.86132 3.10024 8.97567 2.91727 9.05437C2.7343 9.13307 2.53749 9.17454 2.33832 9.17636C2.13915 9.17819 1.94162 9.14033 1.75724 9.06499C1.57286 8.98966 1.40533 8.87836 1.26443 8.73759C1.12352 8.59682 1.01206 8.42939 0.936554 8.24508C0.861046 8.06077 0.822999 7.86327 0.824636 7.6641C0.826272 7.46494 0.867558 7.26809 0.946084 7.08504C1.02461 6.902 1.1388 6.73643 1.282 6.59799L6.94 0.939992Z",fill:"#353535"})}),h=()=>(0,l.jsx)("svg",{width:"14",height:"9",viewBox:"0 0 15 9",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,l.jsx)("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M8.2171 8.23643C7.93585 8.51733 7.5546 8.67511 7.1571 8.67511C6.7596 8.67511 6.37835 8.51733 6.0971 8.23643L0.439102 2.58043C0.299835 2.4411 0.189377 2.2757 0.114031 2.09368C0.0386848 1.91165 -7.15256e-05 1.71658 -2.47955e-05 1.51958C2.19345e-05 1.32258 0.0388708 1.12751 0.114302 0.945529C0.189733 0.763543 0.300269 0.598197 0.439602 0.45893C0.578935 0.319663 0.744334 0.209204 0.926355 0.133858C1.10838 0.0585117 1.30346 0.0197554 1.50046 0.0198021C1.69746 0.0198488 1.89252 0.0586977 2.0745 0.134129C2.25649 0.209559 2.42183 0.320097 2.5611 0.45943L7.1571 5.05443L11.7531 0.458429C11.8914 0.315101 12.0569 0.200749 12.2398 0.122051C12.4228 0.0433531 12.6196 0.00188351 12.8188 5.91278e-05C13.018 -0.00176525 13.2155 0.0360947 13.3999 0.111429C13.5842 0.186764 13.7518 0.298063 13.8927 0.438835C14.0336 0.579607 14.145 0.747032 14.2206 0.93134C14.2961 1.11565 14.3341 1.31315 14.3325 1.51232C14.3308 1.71149 14.2895 1.90834 14.211 2.09138C14.1325 2.27442 14.0183 2.43999 13.8751 2.57843L8.2171 8.23643Z",fill:"#353535"})}),m=()=>(0,l.jsx)("svg",{width:"10",height:"14",viewBox:"0 0 10 15",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,l.jsx)("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M1.092 8.88977C0.8111 8.60852 0.65332 8.22727 0.65332 7.82977C0.65332 7.43227 0.8111 7.05102 1.092 6.76977L6.748 1.11177C6.88733 0.972504 7.05273 0.862045 7.23475 0.786699C7.41678 0.711353 7.61185 0.672597 7.80885 0.672644C8.00585 0.67269 8.20092 0.711539 8.3829 0.78697C8.56489 0.862401 8.73023 0.972938 8.8695 1.11227C9.00877 1.2516 9.11923 1.417 9.19457 1.59902C9.26992 1.78104 9.30867 1.97612 9.30863 2.17312C9.30858 2.37012 9.26973 2.56519 9.1943 2.74717C9.11887 2.92916 9.00833 3.0945 8.869 3.23377L4.274 7.82977L8.87 12.4258C9.01333 12.5641 9.12768 12.7295 9.20638 12.9125C9.28508 13.0955 9.32655 13.2923 9.32837 13.4915C9.3302 13.6906 9.29234 13.8882 9.217 14.0725C9.14167 14.2569 9.03037 14.4244 8.8896 14.5653C8.74882 14.7063 8.5814 14.8177 8.39709 14.8932C8.21278 14.9687 8.01528 15.0068 7.81611 15.0051C7.61694 15.0035 7.42009 14.9622 7.23705 14.8837C7.05401 14.8052 6.88844 14.691 6.75 14.5478L1.092 8.88977Z",fill:"#353535"})}),w=()=>(0,l.jsx)("svg",{width:"10",height:"14",viewBox:"0 0 10 15",fill:"none",xmlns:"http://www.w3.org/2000/svg",children:(0,l.jsx)("path",{"fill-rule":"evenodd","clip-rule":"evenodd",d:"M9.0651 6.28668C9.346 6.56793 9.50378 6.94918 9.50378 7.34668C9.50378 7.74418 9.346 8.12543 9.0651 8.40668L3.4091 14.0647C3.26977 14.2039 3.10437 14.3144 2.92235 14.3898C2.74033 14.4651 2.54525 14.5039 2.34825 14.5038C2.15125 14.5038 1.95619 14.4649 1.7742 14.3895C1.59222 14.3141 1.42687 14.2035 1.2876 14.0642C1.14834 13.9248 1.03788 13.7594 0.962532 13.5774C0.887186 13.3954 0.84843 13.2003 0.848476 13.0033C0.848523 12.8063 0.887372 12.6113 0.962803 12.4293C1.03823 12.2473 1.14877 12.0819 1.2881 11.9427L5.8831 7.34668L1.2871 2.75068C1.14377 2.61238 1.02942 2.44692 0.950726 2.26395C0.872027 2.08098 0.830558 1.88417 0.828733 1.685C0.826909 1.48583 0.864769 1.2883 0.940104 1.10392C1.01544 0.919539 1.12674 0.75201 1.26751 0.611105C1.40828 0.4702 1.57571 0.358742 1.76001 0.283234C1.94432 0.207725 2.14182 0.169679 2.34099 0.171315C2.54016 0.172951 2.73701 0.214237 2.92005 0.292763C3.1031 0.371289 3.26867 0.485483 3.4071 0.628682L9.0651 6.28668Z",fill:"#353535"})}),g=(window.wp.apiFetch,window.wp.element,e=>!!e&&(Array.isArray(e)?e.some((e=>g(e?.list?e.list:e))):"object"==typeof e?e.hasOwnProperty("text")?g(e.text):Object.values(e).some((e=>g(e))):"string"==typeof e&&/^\[affiliatex-product(\s+[^=\s]+=[^\]]+)*\]$/.test(e.trim()))),v={add:(0,l.jsx)(u,{}),remove:(0,l.jsx)(p,{}),upload:(0,l.jsx)(C,{}),replace:(0,l.jsx)(f,{}),up:(0,l.jsx)(x,{}),down:(0,l.jsx)(h,{}),left:(0,l.jsx)(m,{}),right:(0,l.jsx)(w,{}),amazon:(0,l.jsx)(r,{})},A=(e,t="")=>`affx-action-button affx-action-button__${e} ${t}`.trim(),T=({type:e,onClick:t,className:i="",disabled:n,multiButtonProps:a,secondaryIcon:o,...s})=>a?(0,l.jsx)("div",{className:`affx-action-button-wrapper ${i}`,children:a.map(((e,t)=>(0,l.jsx)("button",{className:A(e.type,e.className),onClick:e.onClick,disabled:e.disabled,children:v[e.type]},t)))}):(0,l.jsxs)("button",{className:A(e,i),onClick:t,disabled:n,...s,children:[o&&(0,l.jsx)("span",{className:"affx-action-button__secondary-icon",children:o}),v[e]]}),b=({onClick:e,className:n="",isToolbarButton:a=!1,type:r,setAttributes:C,field:u,value:f})=>{const{name:p}=(0,t.useBlockEditContext)(),x=p.startsWith("affiliatex/"),h=(a&&x&&s.ToolbarButton,window.AffiliateX&&"true"===window.AffiliateX.proActive),{setActiveModal:m,setUpgradeModal:w,setAmazonFieldType:v,setCurrentAttributesField:A}=(0,i.useDispatch)("affiliatex"),b=f&&g(f.toString()),j=(0,l.jsx)(T,{type:"amazon",label:b?(0,o.__)("Change Amazon Product","affiliatex"):(0,o.__)("Link Amazon Product","affiliatex"),onClick:()=>{e&&e(),m(h?"amazon-modal":"upgrade-modal"),v(null!=r?r:"text"),u&&A(u),h||w({modalType:"amazon",modalTitle:(0,o.__)("Amazon Integration","affiliatex"),blockTitle:(0,o.__)("Amazon Integration","affiliatex")})},className:`${b?"is-connected":""} ${n}`.trim(),secondaryIcon:h?b&&(0,l.jsx)(d,{}):(0,l.jsx)(c,{})});return a&&x?(0,l.jsx)(t.BlockControls,{children:j}):j},j=e=>{if("string"==typeof e)return e;if(e.parent){const{parent:t,name:i,index:l}=e;return`${t}.${void 0!==l?l:""}.${i}`}return e?.name};let k=!1;const _={activeModal:"",amazonFieldType:"text",upgradeModal:{blockTitle:"",demoSlug:""},currentAttributesField:"",connectedProduct:null,isProductSidebarOpen:!1,popoverBlockClientId:null},M=(0,i.createReduxStore)("affiliatex",{reducer(e=_,t){switch(t.type){case"SET_ACTIVE_MODAL":return{...e,activeModal:t.activeModal};case"SET_UPGRADE_MODAL":return{...e,upgradeModal:{...e.upgradeModal,...t.upgradeModal}};case"SET_AMAZON_FIELD_TYPE":return{...e,amazonFieldType:t.amazonFieldType};case"SET_CURRENT_ATTRIBUTES_FIELD":return{...e,currentAttributesField:t.field};case"SET_CONNECTED_PRODUCT":return{...e,connectedProduct:t.product};case"SET_PRODUCT_SIDEBAR_OPEN":return{...e,isProductSidebarOpen:t.isOpen};case"SET_POPOVER_BLOCK_CLIENT_ID":return{...e,popoverBlockClientId:t.blockClientId};case"RESET_AMAZON_STATE":return{...e,connectedProduct:null,isProductSidebarOpen:!1}}return e},actions:{setActiveModal:e=>({type:"SET_ACTIVE_MODAL",activeModal:e}),setUpgradeModal:e=>({type:"SET_UPGRADE_MODAL",upgradeModal:e}),setAmazonFieldType:e=>({type:"SET_AMAZON_FIELD_TYPE",amazonFieldType:e}),setCurrentAttributesField:e=>({type:"SET_CURRENT_ATTRIBUTES_FIELD",field:e}),setConnectedProduct:e=>({type:"SET_CONNECTED_PRODUCT",product:e}),setProductSidebarOpen:e=>({type:"SET_PRODUCT_SIDEBAR_OPEN",isOpen:e}),setPopoverBlockClientId:e=>({type:"SET_POPOVER_BLOCK_CLIENT_ID",blockClientId:e}),resetAmazonState:()=>({type:"RESET_AMAZON_STATE"})},selectors:{getActiveModal(e){const{activeModal:t}=e;return t},getUpgradeModal(e){const{upgradeModal:t}=e;return t},getAmazonFieldType(e){const{amazonFieldType:t}=e;return t},getCurrentAttributes:e=>e.currentAttributes,getCurrentAttributesField:e=>e.currentAttributesField,getConnectedProduct:e=>e.connectedProduct,isProductSidebarOpen:e=>e.isProductSidebarOpen,getPopoverBlockClientId:e=>e.popoverBlockClientId}}),E=AffiliateX.customizationData;if("custom"===E.editorWidth){let e=document.createElement("style");e.innerHTML=`\n\t#editor .editor-styles-wrapper .wp-block{\n\tmax-width: ${E.editorCustomWidth}px\n\t}\n`,document.head.appendChild(e)}if("custom"===E.editorSidebarWidth){let e=document.createElement("style");e.innerHTML=`\n\t#editor .is-sidebar-opened .interface-interface-skeleton__sidebar, #editor .is-sidebar-opened .interface-complementary-area{\n\twidth: ${E.editorCustomSidebarWidth}px\n\t}\n`,document.head.appendChild(e)}(()=>{if(!k)try{(0,e.registerFormatType)("affiliatex/amazon-product",{title:(0,o.__)("Amazon Product List","affiliatex"),tagName:"span",className:"affx-amazon-toolbar-btn",edit:({isActive:e,value:t,onChange:n})=>{const a=(0,i.useSelect)((e=>e("core/block-editor").getSelectedBlock())),o=(0,i.useSelect)((e=>e("affiliatex").getCurrentAttributesField()));let s=!0===o?.nested?"object"==typeof o.index?a?.attributes?.[o.parent]?.[o.index.parentIndex]?.[o.name]?.[o.index.childIndex]:a?.attributes?.[o.parent]?.[o.index]?.[o.name]:a?.attributes?.[o.name];return Array.isArray(s)&&1===s.length&&s[0]?.list&&g(s[0]?.list)&&(s=s[0]?.list),a&&a.name.startsWith("affiliatex/")&&!(e=>{const t=e?.attributes?.excludeAmazonFields||[];return((e,t)=>{const i=j(e);return t.some((e=>(e=>{const t=e.replace(/\./g,"\\.").replace(/\*/g,".*");return new RegExp(`^${t}$`)})(j(e)).test(i)))})((0,i.useSelect)((e=>e("affiliatex").getCurrentAttributesField())),t)})(a)?(0,l.jsx)(b,{className:"affx-amazon-toolbar-btn",isToolbarButton:!0,setAttributes:a.setAttributes,field:o,value:s,type:"text"}):null}}),k=!0}catch(e){console.error("Failed to register Amazon format:",e)}})(),(0,i.register)(M),(affiliatexExports=void 0===affiliatexExports?{}:affiliatexExports).blocks={}})();