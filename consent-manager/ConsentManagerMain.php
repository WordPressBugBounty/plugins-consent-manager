<?php

/**
 * Class ConsentManagerMain
 */
class ConsentManagerMain
{
    const ADMIN_URL = 'consent_manager_admin';
    const OPTION_ID = 'consent_manager_id';
    const OPTION_CODEID = 'consent_manager_code_id';
    const OPTION_HOST = 'consent_manager_host';
    const OPTION_CDN = 'consent_manager_cdn';
    const OPTION_MODE = 'consent_manager_mode';
    const OPTION_IGNORE_DOMAINS = 'consent_manager_ignore_domains';
    const HOST = 'delivery.consentmanager.net';
    const CDN = 'cdn.consentmanager.net';
    const HIDE_ON_EDITOR = 'consent_manager_hide_on_editor';

    /**
     * @return string
     */
    public static function getAdminUrl()
    {
        return "options-general.php?page=" . self::ADMIN_URL;
    }

    /**
     * @return string
     */
    public static function getAdminUrlConst()
    {
        return self::ADMIN_URL;
    }

    /**
     * @return string
     */
    public static function getOptionID()
    {
        return self::OPTION_ID;
    }

    /**
     * @return string
     */
    public static function getOptionCodeID()
    {
        return self::OPTION_CODEID;
    }

    /**
     * @return string
     */
    public static function getOptionHost()
    {
        return self::OPTION_HOST;
    }

    /**
     * @return string
     */
    public static function getOptionCDN()
    {
        return self::OPTION_CDN;
    }

    /**
     * @return string
     */
    public static function getOptionMode()
    {
        return self::OPTION_MODE;
    }

    /**
     * @return string
     */
    public static function getOptionIgnoreDomains()
    {
        return self::OPTION_IGNORE_DOMAINS;
    }

    /**
     * @return string
     */
    public static function getHost()
    {
        return self::HOST;
    }

    /**
     * @return string
     */
    public static function getCDN()
    {
        return self::CDN;
    }

    /**
     * @return string
     */
    public static function getHideOnEditor()
    {
        return self::HIDE_ON_EDITOR;
    }

    /**
     * @param $id
     * @param $codeID
     * @param $host
     * @param $cdn
     * @return string
     */
    public static function getSemiBlockingCode($id, $codeID, $host, $cdn)
    {
        if ((int)$id > 0 && $codeID != '') {
            $id = 0;
        }
        return '<script>window.gdprAppliesGlobally=true;if(!("cmp_id" in window)||window.cmp_id<1){window.cmp_id=' . $id . '}if(!("cmp_cdid" in window)){window.cmp_cdid="' . $codeID . '"}if(!("cmp_params" in window)){window.cmp_params=""}if(!("cmp_host" in window)){window.cmp_host="' . $host . '"}if(!("cmp_cdn" in window)){window.cmp_cdn="' . $cdn . '"}if(!("cmp_proto" in window)){window.cmp_proto="https:"}if(!("cmp_codesrc" in window)){window.cmp_codesrc="10"}window.cmp_getsupportedLangs=function(){var b=["DE","EN","FR","IT","NO","DA","FI","ES","PT","RO","BG","ET","EL","GA","HR","LV","LT","MT","NL","PL","SV","SK","SL","CS","HU","RU","SR","ZH","TR","UK","AR","BS"];if("cmp_customlanguages" in window){for(var a=0;a<window.cmp_customlanguages.length;a++){b.push(window.cmp_customlanguages[a].l.toUpperCase())}}return b};window.cmp_getRTLLangs=function(){var a=["AR"];if("cmp_customlanguages" in window){for(var b=0;b<window.cmp_customlanguages.length;b++){if("r" in window.cmp_customlanguages[b]&&window.cmp_customlanguages[b].r){a.push(window.cmp_customlanguages[b].l)}}}return a};window.cmp_getlang=function(j){if(typeof(j)!="boolean"){j=true}if(j&&typeof(cmp_getlang.usedlang)=="string"&&cmp_getlang.usedlang!==""){return cmp_getlang.usedlang}var g=window.cmp_getsupportedLangs();var c=[];var f=location.hash;var e=location.search;var a="languages" in navigator?navigator.languages:[];if(f.indexOf("cmplang=")!=-1){c.push(f.substr(f.indexOf("cmplang=")+8,2).toUpperCase())}else{if(e.indexOf("cmplang=")!=-1){c.push(e.substr(e.indexOf("cmplang=")+8,2).toUpperCase())}else{if("cmp_setlang" in window&&window.cmp_setlang!=""){c.push(window.cmp_setlang.toUpperCase())}else{if(a.length>0){for(var d=0;d<a.length;d++){c.push(a[d])}}}}}if("language" in navigator){c.push(navigator.language)}if("userLanguage" in navigator){c.push(navigator.userLanguage)}var h="";for(var d=0;d<c.length;d++){var b=c[d].toUpperCase();if(g.indexOf(b)!=-1){h=b;break}if(b.indexOf("-")!=-1){b=b.substr(0,2)}if(g.indexOf(b)!=-1){h=b;break}}if(h==""&&typeof(cmp_getlang.defaultlang)=="string"&&cmp_getlang.defaultlang!==""){return cmp_getlang.defaultlang}else{if(h==""){h="EN"}}h=h.toUpperCase();return h};(function(){var n=document;var p=n.getElementsByTagName;var q=window;var f="";var b="_en";if("cmp_getlang" in q){f=q.cmp_getlang().toLowerCase();if("cmp_customlanguages" in q){for(var h=0;h<q.cmp_customlanguages.length;h++){if(q.cmp_customlanguages[h].l.toUpperCase()==f.toUpperCase()){f="en";break}}}b="_"+f}function g(i,e){var t="";i+="=";var s=i.length;var d=location;if(d.hash.indexOf(i)!=-1){t=d.hash.substr(d.hash.indexOf(i)+s,9999)}else{if(d.search.indexOf(i)!=-1){t=d.search.substr(d.search.indexOf(i)+s,9999)}else{return e}}if(t.indexOf("&")!=-1){t=t.substr(0,t.indexOf("&"))}return t}var j=("cmp_proto" in q)?q.cmp_proto:"https:";if(j!="http:"&&j!="https:"){j="https:"}var k=("cmp_ref" in q)?q.cmp_ref:location.href;var r=n.createElement("script");r.setAttribute("data-cmp-ab","1");var c=g("cmpdesign","cmp_design" in q?q.cmp_design:"");var a=g("cmpregulationkey","cmp_regulationkey" in q?q.cmp_regulationkey:"");var o=g("cmpatt","cmp_att" in q?q.cmp_att:"");r.src=j+"//"+q.cmp_host+"/delivery/cmp.php?"+("cmp_id" in q&&q.cmp_id>0?"id="+q.cmp_id:"")+("cmp_cdid" in q?"&cdid="+q.cmp_cdid:"")+"&h="+encodeURIComponent(k)+(c!=""?"&cmpdesign="+encodeURIComponent(c):"")+(a!=""?"&cmpregulationkey="+encodeURIComponent(a):"")+(o!=""?"&cmpatt="+encodeURIComponent(o):"")+("cmp_params" in q?"&"+q.cmp_params:"")+(n.cookie.length>0?"&__cmpfcc=1":"")+"&l="+f.toLowerCase()+"&o="+(new Date()).getTime();r.type="text/javascript";r.async=true;if(n.currentScript&&n.currentScript.parentElement){n.currentScript.parentElement.appendChild(r)}else{if(n.body){n.body.appendChild(r)}else{var m=p("body");if(m.length==0){m=p("div")}if(m.length==0){m=p("span")}if(m.length==0){m=p("ins")}if(m.length==0){m=p("script")}if(m.length==0){m=p("head")}if(m.length>0){m[0].appendChild(r)}}}var r=n.createElement("script");r.src=j+"//"+q.cmp_cdn+"/delivery/js/cmp"+b+".min.js";r.type="text/javascript";r.setAttribute("data-cmp-ab","1");r.async=true;if(n.currentScript&&n.currentScript.parentElement){n.currentScript.parentElement.appendChild(r)}else{if(n.body){n.body.appendChild(r)}else{var m=p("body");if(m.length==0){m=p("div")}if(m.length==0){m=p("span")}if(m.length==0){m=p("ins")}if(m.length==0){m=p("script")}if(m.length==0){m=p("head")}if(m.length>0){m[0].appendChild(r)}}}})();window.cmp_addFrame=function(b){if(!window.frames[b]){if(document.body){var a=document.createElement("iframe");a.style.cssText="display:none";if("cmp_cdn" in window&&"cmp_ultrablocking" in window&&window.cmp_ultrablocking>0){a.src="//"+window.cmp_cdn+"/delivery/empty.html"}a.name=b;document.body.appendChild(a)}else{window.setTimeout(window.cmp_addFrame,10,b)}}};window.cmp_rc=function(h){var b=document.cookie;var f="";var d=0;while(b!=""&&d<100){d++;while(b.substr(0,1)==" "){b=b.substr(1,b.length)}var g=b.substring(0,b.indexOf("="));if(b.indexOf(";")!=-1){var c=b.substring(b.indexOf("=")+1,b.indexOf(";"))}else{var c=b.substr(b.indexOf("=")+1,b.length)}if(h==g){f=c}var e=b.indexOf(";")+1;if(e==0){e=b.length}b=b.substring(e,b.length)}return(f)};window.cmp_stub=function(){var a=arguments;__cmp.a=__cmp.a||[];if(!a.length){return __cmp.a}else{if(a[0]==="ping"){if(a[1]===2){a[2]({gdprApplies:gdprAppliesGlobally,cmpLoaded:false,cmpStatus:"stub",displayStatus:"hidden",apiVersion:"2.0",cmpId:31},true)}else{a[2](false,true)}}else{if(a[0]==="getUSPData"){a[2]({version:1,uspString:window.cmp_rc("")},true)}else{if(a[0]==="getTCData"){__cmp.a.push([].slice.apply(a))}else{if(a[0]==="addEventListener"||a[0]==="removeEventListener"){__cmp.a.push([].slice.apply(a))}else{if(a.length==4&&a[3]===false){a[2]({},false)}else{__cmp.a.push([].slice.apply(a))}}}}}}};window.cmp_gppstub=function(){var a=arguments;__gpp.q=__gpp.q||[];if(!a.length){return __gpp.q}var g=a[0];var f=a.length>1?a[1]:null;var e=a.length>2?a[2]:null;if(g==="ping"){return{gppVersion:"1.0",cmpStatus:"stub",cmpDisplayStatus:"hidden",apiSupport:["tcfeuv2","tcfva","usnat"],currentAPI:"",cmpId:31}}else{if(g==="addEventListener"){__gpp.e=__gpp.e||[];if(!("lastId" in __gpp)){__gpp.lastId=0}__gpp.lastId++;var c=__gpp.lastId;__gpp.e.push({id:c,callback:f});return{eventName:"listenerRegistered",listenerId:c,data:true,pingData:{gppVersion:"1.0",cmpStatus:"stub",cmpDisplayStatus:"hidden",apiSupport:[],currentAPI:"",cmpId:31}}}else{if(g==="removeEventListener"){var h=false;__gpp.e=__gpp.e||[];for(var d=0;d<__gpp.e.length;d++){if(__gpp.e[d].id==e){__gpp.e[d].splice(d,1);h=true;break}}return{eventName:"listenerRemoved",listenerId:e,data:h}}else{if(g==="hasSection"||g==="getSection"||g==="getField"||g==="getGPPString"){return null}else{__gpp.q.push([].slice.apply(a))}}}}};window.cmp_msghandler=function(d){var a=typeof d.data==="string";try{var c=a?JSON.parse(d.data):d.data}catch(f){var c=null}if(typeof(c)==="object"&&c!==null&&"__cmpCall" in c){var b=c.__cmpCall;window.__cmp(b.command,b.parameter,function(h,g){var e={__cmpReturn:{returnValue:h,success:g,callId:b.callId}};d.source.postMessage(a?JSON.stringify(e):e,"*")})}if(typeof(c)==="object"&&c!==null&&"__uspapiCall" in c){var b=c.__uspapiCall;window.__uspapi(b.command,b.version,function(h,g){var e={__uspapiReturn:{returnValue:h,success:g,callId:b.callId}};d.source.postMessage(a?JSON.stringify(e):e,"*")})}if(typeof(c)==="object"&&c!==null&&"__tcfapiCall" in c){var b=c.__tcfapiCall;window.__tcfapi(b.command,b.version,function(h,g){var e={__tcfapiReturn:{returnValue:h,success:g,callId:b.callId}};d.source.postMessage(a?JSON.stringify(e):e,"*")},b.parameter)}if(typeof(c)==="object"&&c!==null&&"__gppCall" in c){var b=c.__gppCall;window.__gpp(b.command,function(h,g){var e={__gppReturn:{returnValue:h,success:g,callId:b.callId}};d.source.postMessage(a?JSON.stringify(e):e,"*")},b.parameter,"version" in b?b.version:1)}};window.cmp_setStub=function(a){if(!(a in window)||(typeof(window[a])!=="function"&&typeof(window[a])!=="object"&&(typeof(window[a])==="undefined"||window[a]!==null))){window[a]=window.cmp_stub;window[a].msgHandler=window.cmp_msghandler;window.addEventListener("message",window.cmp_msghandler,false)}};window.cmp_setGppStub=function(a){if(!(a in window)||(typeof(window[a])!=="function"&&typeof(window[a])!=="object"&&(typeof(window[a])==="undefined"||window[a]!==null))){window[a]=window.cmp_gppstub;window[a].msgHandler=window.cmp_msghandler;window.addEventListener("message",window.cmp_msghandler,false)}};window.cmp_addFrame("__cmpLocator");if(!("cmp_disableusp" in window)||!window.cmp_disableusp){window.cmp_addFrame("__uspapiLocator")}if(!("cmp_disabletcf" in window)||!window.cmp_disabletcf){window.cmp_addFrame("__tcfapiLocator")}if(!("cmp_disablegpp" in window)||!window.cmp_disablegpp){window.cmp_addFrame("__gppLocator")}window.cmp_setStub("__cmp");if(!("cmp_disabletcf" in window)||!window.cmp_disabletcf){window.cmp_setStub("__tcfapi")}if(!("cmp_disableusp" in window)||!window.cmp_disableusp){window.cmp_setStub("__uspapi")}if(!("cmp_disablegpp" in window)||!window.cmp_disablegpp){window.cmp_setGppStub("__gpp")};</script>';
    }

    /**
     * @param $url
     * @return array|string|string[]
     */
    public static function removeProtocol($url)
    {
        $removeProtocol = array('http://', 'https://');
        return str_replace($removeProtocol, '', $url);
    }


    /**
     * temporary deactivated until found perfomance solution for serverside blocking
     * @param $url
     * @return false|mixed|string
     *
     * public static function getDomainFromUrl($url)
     * {
     * if ($url !== '') {
     * $info = parse_url($url);
     * $host = $info['host'];
     * return $host;
     * }
     * return false;
     * }
     */

    /**
     * temporary deactivated until found perfomance solution for serverside blocking
     *
     * @param $domain
     * @param $id
     * @return bool
     *
     * public static function sendUnblockedDomainInfo($domain, $id)
     * {
     * if (rand(1, 100) === 1) {
     * file_get_contents('https://' . ConsentManagerMain::getHost() . '/delivery/alertdomains.php?id=' . $id . '&ref=' . urlencode(self::getSiteUrl()) . '&url=' . urlencode($domain));
     * }
     * return true;
     * }
     */

    /**
     * temporary deactivated until found perfomance solution for serverside blocking
     *
     * @param false $protocol
     * @return mixed|string
     *
     * public static function getSiteURL($protocol = false)
     * {
     * $_protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
     * $domainName = $_SERVER['HTTP_HOST'];
     * return $protocol ? $_protocol . $domainName : $domainName;
     * }
     */

    /**
     * temporary deactivated until found perfomance solution for serverside blocking
     * @param $string
     * @return mixed|string
     *
     * public static function getUrlFromString($string)
     * {
     * preg_match('/(src=["\'](.*?)["\'])/', $string, $match);  //find src="X" or src='X'
     * $split = preg_split('/["\']/', $match[0]); // split by quotes
     * $src = $split[1]; // X between quotes
     * return $src;
     * }
     */

}