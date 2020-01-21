<?php
/**
 * Created by PhpStorm.
 * User: TaroonG
 * Date: 2016-09-06
 * Time: 09:36 AM
 */

namespace App;


class AttachmentHelper
{

    public $mimeType;
    public $pathToFile;
    public $extension;
    public $mime;
    public $size;
    public $humanReadableSize;
    public $extendedMime;
    public $canPreview;

    private $fInfo;

    public static function fromBlob($data, $originalFileName) {
        $obj = new AttachmentHelper();

        // prepare tmp path to save file
        $obj->pathToFile = storage_path() ."/tmp/" .$originalFileName;

        //if (!file_exists($obj->pathToFile)) {
        //    file_put_contents($obj->pathToFile, $data);
        //}

        // Code above commented to force download of existing file in the storage folder.
        // Issue arrised when user were uploading same filename with different content
        file_put_contents($obj->pathToFile, $data);
        return self::commonBlock($obj);

    }

    public static function fromPath($file) {
        $obj = new AttachmentHelper();

        $obj->pathToFile = $file;

        return self::commonBlock($obj);
    }

    public static function commonBlock($obj) {
        $obj->extension = strtolower(pathinfo($obj->pathToFile, PATHINFO_EXTENSION));

        // load the written file and get mime type
        $obj->fInfo    = finfo_open(FILEINFO_MIME);
        $obj->mimeType = finfo_file($obj->fInfo, $obj->pathToFile);

        $obj->size = self::findFilesize($obj->pathToFile);
        $obj->humanReadableSize = self::humanFileSize($obj->size);
        $obj->extendedMime = self::friendlyFileType($obj->extension);
        $obj->canPreview = ($obj->extendedMime['group'] == 'Document' && $obj->extension == 'pdf');

        switch ($obj->extension) {
            case 'mp4':
                $mime = 'video/mp4';
                break;
            case 'mp3':
                $mime = 'audio/mpeg';
                break;
            case 'wav':
                $mime = 'audio/wav';
                break;
            case 'pdf':
                $mime = 'application/pdf';
                break;
            default:
                $mime = $obj->mimeType;
        }
        $obj->mime = $mime;

        finfo_close($obj->fInfo);

        return $obj;
    }

    public static function findFilesize($file)
    {
        if(substr(PHP_OS, 0, 3) == "WIN")
        {
            exec('for %I in ("'.$file.'") do @echo %~zI', $output);
            $return = $output[0];
        } else {
            $return = filesize($file);
        }
        return $return;
    }

    public static function humanFileSize($bytes, $decimals = 2) {
        $factor = floor((strlen($bytes) - 1) / 3);
        if ($factor > 0) $sz = 'KMGT';
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
    }

    public static function friendlyFileType($fileExtension) {
        $mimeTypes = array(
            'aif' => array(
                'name' => 'Audio Interchange File Format',
                'type' => 'audio/x-aiff',
                'group' => 'Audio'
            ),
            'avi' => array(
                'name' => 'Audio Video Interleave (AVI)',
                'type' => 'video/x-msvideo',
                'group' => 'Video'
            ),
            'bmp' => array(
                'name' => 'Bitmap Image File',
                'type' => 'image/bmp',
                'group' => 'Image'
            ),
            'doc' => array(
                'name' => 'Microsoft Word',
                'type' => 'application/msword',
                'group' => 'Document'
            ),
            'docx' => array(
                'name' => 'Microsoft Office - OOXML - Word Document',
                'type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'group' => 'Document'
            ),
            'gif' => array(
                'name' => 'Graphics Interchange Format',
                'type' => 'image/gif',
                'group' => 'Image'
            ),
            'jpeg' => array(
                'name' => 'JPEG Image',
                'type' => 'image/jpeg',
                'group' => 'Image'
            ),
            'jpg' => array(
                'name' => 'JPEG Image',
                'type' => 'image/jpg',
                'group' => 'Image'
            ),
            'mp3' => array(
                'name' => 'MPEG Audio Layer 3',
                'type' => 'audio/mpeg',
                'group' => 'Audio'
            ),
            'mp4' => array(
                'name' => 'MPEG-4 Video',
                'type' => 'video/mp4',
                'group' => 'Video'
            ),
            'ogg' => array(
                'name' => 'Ogg',
                'type' => 'application/ogg',
                'group' => 'Audio'
            ),
            'pdf' => array(
                'name' => 'Adobe Portable Document Format',
                'type' => 'application/pdf',
                'group' => 'Document'
            ),
            'png' => array(
                'name' => 'Portable Network Graphics (PNG)',
                'type' => 'image/png',
                'group' => 'Image'
            ),
            'ppt' => array(
                'name' => 'Microsoft PowerPoint',
                'type' => 'application/vnd.ms-powerpoint',
                'group' => 'Document'
            ),
            'pptx' => array(
                'name' => 'Microsoft Office - OOXML - Presentation',
                'type' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'group' => 'Document'
            ),
            'wav' => array(
                'name' => 'Waveform Audio File Format (WAV)',
                'type' => 'audio/x-wav',
                'group' => 'Audio'
            ),
            'xls' => array(
                'name' => 'Microsoft Excel',
                'type' => 'application/vnd.ms-excel',
                'group' => 'Document'
            ),
            'xlsx' => array(
                'name' => 'Microsoft Office - OOXML - Spreadsheet',
                'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'group' => 'Document'
            ),
            '3gp' => array(
                'name' => '3GP',
                'type' => 'video/3gpp'
            ),
            '3g2' => array(
                'name' => '3GP2',
                'type' => 'video/3gpp2'
            ),
            '7z' => array(
                'name' => '7-Zip',
                'type' => 'application/x-7z-compressed'
            ),
            'abw' => array(
                'name' => 'AbiWord',
                'type' => 'application/x-abiword'
            ),
            'ace' => array(
                'name' => 'Ace Archive',
                'type' => 'application/x-ace-compressed'
            ),
            'acu' => array(
                'name' => 'ACU Cobol',
                'type' => 'application/vnd.acucobol'
            ),
            'atc' => array(
                'name' => 'ACU Cobol',
                'type' => 'application/vnd.acucorp'
            ),
            'adp' => array(
                'name' => 'Adaptive differential pulse-code modulation',
                'type' => 'audio/adpcm'
            ),
            'aab' => array(
                'name' => 'Adobe (Macropedia) Authorware - Binary File',
                'type' => 'application/x-authorware-bin'
            ),
            'aam' => array(
                'name' => 'Adobe (Macropedia) Authorware - Map',
                'type' => 'application/x-authorware-map'
            ),
            'aas' => array(
                'name' => 'Adobe (Macropedia) Authorware - Segment File',
                'type' => 'application/x-authorware-seg'
            ),
            'air' => array(
                'name' => 'Adobe AIR Application',
                'type' => 'application/vnd.adobe.air-application-installer-package+zip'
            ),
            'swf' => array(
                'name' => 'Adobe Flash',
                'type' => 'application/x-shockwave-flash'
            ),
            'fxp' => array(
                'name' => 'Adobe Flex Project',
                'type' => 'application/vnd.adobe.fxp'
            ),
            'apk' => array(
                'name' => 'Android Package Archive',
                'type' => 'application/vnd.android.package-archive'
            ),
            '".atom, .xml"' => array(
                'name' => 'Atom Syndication Format',
                'type' => 'application/atom+xml'
            ),
            'ac' => array(
                'name' => 'Attribute Certificate',
                'type' => 'application/pkix-attr-cert'
            ),
            'torrent' => array(
                'name' => 'BitTorrent',
                'type' => 'application/x-bittorrent'
            ),
            'btif' => array(
                'name' => 'BTIF',
                'type' => 'image/prs.btif'
            ),
            'css' => array(
                'name' => 'Cascading Style Sheets (CSS)',
                'type' => 'text/css'
            ),
            'ice' => array(
                'name' => 'CoolTalk',
                'type' => 'x-conference/x-cooltalk'
            ),
            'cmx' => array(
                'name' => 'Corel Metafile Exchange (CMX)',
                'type' => 'image/x-cmx'
            ),
            'xar' => array(
                'name' => 'CorelXARA',
                'type' => 'application/vnd.xara'
            ),
            'cmc' => array(
                'name' => 'CosmoCaller',
                'type' => 'application/vnd.cosmocaller'
            ),
            'cpio' => array(
                'name' => 'CPIO Archive',
                'type' => 'application/x-cpio'
            ),
            'clkx' => array(
                'name' => 'CrickSoftware - Clicker',
                'type' => 'application/vnd.crick.clicker'
            ),
            'clkk' => array(
                'name' => 'CrickSoftware - Clicker - Keyboard',
                'type' => 'application/vnd.crick.clicker.keyboard'
            ),
            'clkp' => array(
                'name' => 'CrickSoftware - Clicker - Palette',
                'type' => 'application/vnd.crick.clicker.palette'
            ),
            'clkt' => array(
                'name' => 'CrickSoftware - Clicker - Template',
                'type' => 'application/vnd.crick.clicker.template'
            ),
            'clkw' => array(
                'name' => 'CrickSoftware - Clicker - Wordbank',
                'type' => 'application/vnd.crick.clicker.wordbank'
            ),
            'wbs' => array(
                'name' => 'Critical Tools - PERT Chart EXPERT',
                'type' => 'application/vnd.criticaltools.wbs+xml'
            ),
            'cryptonote' => array(
                'name' => 'CryptoNote',
                'type' => 'application/vnd.rig.cryptonote'
            ),
            'cif' => array(
                'name' => 'Crystallographic Interchange Format',
                'type' => 'chemical/x-cif'
            ),
            'cmdf' => array(
                'name' => 'CrystalMaker Data Format',
                'type' => 'chemical/x-cmdf'
            ),
            'cu' => array(
                'name' => 'CU-SeeMe',
                'type' => 'application/cu-seeme'
            ),
            'cww' => array(
                'name' => 'CU-Writer',
                'type' => 'application/prs.cww'
            ),
            'curl' => array(
                'name' => 'Curl - Applet',
                'type' => 'text/vnd.curl'
            ),
            'dcurl' => array(
                'name' => 'Curl - Detached Applet',
                'type' => 'text/vnd.curl.dcurl'
            ),
            'mcurl' => array(
                'name' => 'Curl - Manifest File',
                'type' => 'text/vnd.curl.mcurl'
            ),
            'scurl' => array(
                'name' => 'Curl - Source Code',
                'type' => 'text/vnd.curl.scurl'
            ),
            'car' => array(
                'name' => 'CURL Applet',
                'type' => 'application/vnd.curl.car'
            ),
            'pcurl' => array(
                'name' => 'CURL Applet',
                'type' => 'application/vnd.curl.pcurl'
            ),
            'cmp' => array(
                'name' => 'CustomMenu',
                'type' => 'application/vnd.yellowriver-custom-menu'
            ),
            'dssc' => array(
                'name' => 'Data Structure for the Security Suitability of Cryptographic Algorithms',
                'type' => 'application/dssc+der'
            ),
            'xdssc' => array(
                'name' => 'Data Structure for the Security Suitability of Cryptographic Algorithms',
                'type' => 'application/dssc+xml'
            ),
            'deb' => array(
                'name' => 'Debian Package',
                'type' => 'application/x-debian-package'
            ),
            'uva' => array(
                'name' => 'DECE Audio',
                'type' => 'audio/vnd.dece.audio'
            ),
            'uvi' => array(
                'name' => 'DECE Graphic',
                'type' => 'image/vnd.dece.graphic'
            ),
            'uvh' => array(
                'name' => 'DECE High Definition Video',
                'type' => 'video/vnd.dece.hd'
            ),
            'uvm' => array(
                'name' => 'DECE Mobile Video',
                'type' => 'video/vnd.dece.mobile'
            ),
            'uvu' => array(
                'name' => 'DECE MP4',
                'type' => 'video/vnd.uvvu.mp4'
            ),
            'uvp' => array(
                'name' => 'DECE PD Video',
                'type' => 'video/vnd.dece.pd'
            ),
            'uvs' => array(
                'name' => 'DECE SD Video',
                'type' => 'video/vnd.dece.sd'
            ),
            'uaa' => array(
                'name' => 'DECE Video',
                'type' => 'video/vnd.dece.video'
            ),
            'dvi' => array(
                'name' => 'Device Independent File Format (DVI)',
                'type' => 'application/x-dvi'
            ),
            'seed' => array(
                'name' => 'Digital Siesmograph Networks - SEED Datafiles',
                'type' => 'application/vnd.fdsn.seed'
            ),
            'dtb' => array(
                'name' => 'Digital Talking Book',
                'type' => 'application/x-dtbook+xml'
            ),
            'res' => array(
                'name' => 'Digital Talking Book - Resource File',
                'type' => 'application/x-dtbresource+xml'
            ),
            'ait' => array(
                'name' => 'Digital Video Broadcasting',
                'type' => 'application/vnd.dvb.ait'
            ),
            'svc' => array(
                'name' => 'Digital Video Broadcasting',
                'type' => 'application/vnd.dvb.service'
            ),
            'eol' => array(
                'name' => 'Digital Winds Music',
                'type' => 'audio/vnd.digital-winds'
            ),
            'djvu' => array(
                'name' => 'DjVu',
                'type' => 'image/vnd.djvu'
            ),
            'dtd' => array(
                'name' => 'Document Type Definition',
                'type' => 'application/xml-dtd'
            ),
            'mlp' => array(
                'name' => 'Dolby Meridian Lossless Packing',
                'type' => 'application/vnd.dolby.mlp'
            ),
            'wad' => array(
                'name' => 'Doom Video Game',
                'type' => 'application/x-doom'
            ),
            'dpg' => array(
                'name' => 'DPGraph',
                'type' => 'application/vnd.dpgraph'
            ),
            'dra' => array(
                'name' => 'DRA Audio',
                'type' => 'audio/vnd.dra'
            ),
            'dfac' => array(
                'name' => 'DreamFactory',
                'type' => 'application/vnd.dreamfactory'
            ),
            'dts' => array(
                'name' => 'DTS Audio',
                'type' => 'audio/vnd.dts'
            ),
            'dtshd' => array(
                'name' => 'DTS High Definition Audio',
                'type' => 'audio/vnd.dts.hd'
            ),
            'dwg' => array(
                'name' => 'DWG Drawing',
                'type' => 'image/vnd.dwg'
            ),
            'geo' => array(
                'name' => 'DynaGeo',
                'type' => 'application/vnd.dynageo'
            ),
            'es' => array(
                'name' => 'ECMAScript',
                'type' => 'application/ecmascript'
            ),
            'mag' => array(
                'name' => 'EcoWin Chart',
                'type' => 'application/vnd.ecowin.chart'
            ),
            'mmr' => array(
                'name' => 'EDMICS 2000',
                'type' => 'image/vnd.fujixerox.edmics-mmr'
            ),
            'rlc' => array(
                'name' => 'EDMICS 2000',
                'type' => 'image/vnd.fujixerox.edmics-rlc'
            ),
            'exi' => array(
                'name' => 'Efficient XML Interchange',
                'type' => 'application/exi'
            ),
            'mgz' => array(
                'name' => 'EFI Proteus',
                'type' => 'application/vnd.proteus.magazine'
            ),
            'epub' => array(
                'name' => 'Electronic Publication',
                'type' => 'application/epub+zip'
            ),
            'eml' => array(
                'name' => 'Email Message',
                'type' => 'message/rfc822'
            ),
            'nml' => array(
                'name' => 'Enliven Viewer',
                'type' => 'application/vnd.enliven'
            ),
            'xpr' => array(
                'name' => 'Express by Infoseek',
                'type' => 'application/vnd.is-xpr'
            ),
            'xif' => array(
                'name' => 'eXtended Image File Format (XIFF)',
                'type' => 'image/vnd.xiff'
            ),
            'xfdl' => array(
                'name' => 'Extensible Forms Description Language',
                'type' => 'application/vnd.xfdl'
            ),
            'emma' => array(
                'name' => 'Extensible MultiModal Annotation',
                'type' => 'application/emma+xml'
            ),
            'ez2' => array(
                'name' => 'EZPix Secure Photo Album',
                'type' => 'application/vnd.ezpix-album'
            ),
            'ez3' => array(
                'name' => 'EZPix Secure Photo Album',
                'type' => 'application/vnd.ezpix-package'
            ),
            'fst' => array(
                'name' => 'FAST Search & Transfer ASA',
                'type' => 'image/vnd.fst'
            ),
            'fvt' => array(
                'name' => 'FAST Search & Transfer ASA',
                'type' => 'video/vnd.fvt'
            ),
            'fbs' => array(
                'name' => 'FastBid Sheet',
                'type' => 'image/vnd.fastbidsheet'
            ),
            'fe_launch' => array(
                'name' => 'FCS Express Layout Link',
                'type' => 'application/vnd.denovo.fcselayout-link'
            ),
            'f4v' => array(
                'name' => 'Flash Video',
                'type' => 'video/x-f4v'
            ),
            'flv' => array(
                'name' => 'Flash Video',
                'type' => 'video/x-flv'
            ),
            'fpx' => array(
                'name' => 'FlashPix',
                'type' => 'image/vnd.fpx'
            ),
            'npx' => array(
                'name' => 'FlashPix',
                'type' => 'image/vnd.net-fpx'
            ),
            'flx' => array(
                'name' => 'FLEXSTOR',
                'type' => 'text/vnd.fmi.flexstor'
            ),
            'fli' => array(
                'name' => 'FLI/FLC Animation Format',
                'type' => 'video/x-fli'
            ),
            'ftc' => array(
                'name' => 'FluxTime Clip',
                'type' => 'application/vnd.fluxtime.clip'
            ),
            'fdf' => array(
                'name' => 'Forms Data Format',
                'type' => 'application/vnd.fdf'
            ),
            'f' => array(
                'name' => 'Fortran Source File',
                'type' => 'text/x-fortran'
            ),
            'mif' => array(
                'name' => 'FrameMaker Interchange Format',
                'type' => 'application/vnd.mif'
            ),
            'fm' => array(
                'name' => 'FrameMaker Normal Format',
                'type' => 'application/vnd.framemaker'
            ),
            'fh' => array(
                'name' => 'FreeHand MX',
                'type' => 'image/x-freehand'
            ),
            'fsc' => array(
                'name' => 'Friendly Software Corporation',
                'type' => 'application/vnd.fsc.weblaunch'
            ),
            'fnc' => array(
                'name' => 'Frogans Player',
                'type' => 'application/vnd.frogans.fnc'
            ),
            'ltf' => array(
                'name' => 'Frogans Player',
                'type' => 'application/vnd.frogans.ltf'
            ),
            'ddd' => array(
                'name' => 'Fujitsu - Xerox 2D CAD Data',
                'type' => 'application/vnd.fujixerox.ddd'
            ),
            'xdw' => array(
                'name' => 'Fujitsu - Xerox DocuWorks',
                'type' => 'application/vnd.fujixerox.docuworks'
            ),
            'xbd' => array(
                'name' => 'Fujitsu - Xerox DocuWorks Binder',
                'type' => 'application/vnd.fujixerox.docuworks.binder'
            ),
            'oas' => array(
                'name' => 'Fujitsu Oasys',
                'type' => 'application/vnd.fujitsu.oasys'
            ),
            'oa2' => array(
                'name' => 'Fujitsu Oasys',
                'type' => 'application/vnd.fujitsu.oasys2'
            ),
            'oa3' => array(
                'name' => 'Fujitsu Oasys',
                'type' => 'application/vnd.fujitsu.oasys3'
            ),
            'fg5' => array(
                'name' => 'Fujitsu Oasys',
                'type' => 'application/vnd.fujitsu.oasysgp'
            ),
            'bh2' => array(
                'name' => 'Fujitsu Oasys',
                'type' => 'application/vnd.fujitsu.oasysprs'
            ),
            'spl' => array(
                'name' => 'FutureSplash Animator',
                'type' => 'application/x-futuresplash'
            ),
            'fzs' => array(
                'name' => 'FuzzySheet',
                'type' => 'application/vnd.fuzzysheet'
            ),
            'g3' => array(
                'name' => 'G3 Fax Image',
                'type' => 'image/g3fax'
            ),
            'gmx' => array(
                'name' => 'GameMaker ActiveX',
                'type' => 'application/vnd.gmx'
            ),
            'gtw' => array(
                'name' => 'Gen-Trix Studio',
                'type' => 'model/vnd.gtw'
            ),
            'txd' => array(
                'name' => 'Genomatix Tuxedo Framework',
                'type' => 'application/vnd.genomatix.tuxedo'
            ),
            'ggb' => array(
                'name' => 'GeoGebra',
                'type' => 'application/vnd.geogebra.file'
            ),
            'ggt' => array(
                'name' => 'GeoGebra',
                'type' => 'application/vnd.geogebra.tool'
            ),
            'gdl' => array(
                'name' => 'Geometric Description Language (GDL)',
                'type' => 'model/vnd.gdl'
            ),
            'gex' => array(
                'name' => 'GeoMetry Explorer',
                'type' => 'application/vnd.geometry-explorer'
            ),
            'gxt' => array(
                'name' => 'GEONExT and JSXGraph',
                'type' => 'application/vnd.geonext'
            ),
            'g2w' => array(
                'name' => 'GeoplanW',
                'type' => 'application/vnd.geoplan'
            ),
            'g3w' => array(
                'name' => 'GeospacW',
                'type' => 'application/vnd.geospace'
            ),
            'gsf' => array(
                'name' => 'Ghostscript Font',
                'type' => 'application/x-font-ghostscript'
            ),
            'bdf' => array(
                'name' => 'Glyph Bitmap Distribution Format',
                'type' => 'application/x-font-bdf'
            ),
            'gtar' => array(
                'name' => 'GNU Tar Files',
                'type' => 'application/x-gtar'
            ),
            'texinfo' => array(
                'name' => 'GNU Texinfo Document',
                'type' => 'application/x-texinfo'
            ),
            'gnumeric' => array(
                'name' => 'Gnumeric',
                'type' => 'application/x-gnumeric'
            ),
            'kml' => array(
                'name' => 'Google Earth - KML',
                'type' => 'application/vnd.google-earth.kml+xml'
            ),
            'kmz' => array(
                'name' => 'Google Earth - Zipped KML',
                'type' => 'application/vnd.google-earth.kmz'
            ),
            'gqf' => array(
                'name' => 'GrafEq',
                'type' => 'application/vnd.grafeq'
            ),
            'gv' => array(
                'name' => 'Graphviz',
                'type' => 'text/vnd.graphviz'
            ),
            'gac' => array(
                'name' => 'Groove - Account',
                'type' => 'application/vnd.groove-account'
            ),
            'ghf' => array(
                'name' => 'Groove - Help',
                'type' => 'application/vnd.groove-help'
            ),
            'gim' => array(
                'name' => 'Groove - Identity Message',
                'type' => 'application/vnd.groove-identity-message'
            ),
            'grv' => array(
                'name' => 'Groove - Injector',
                'type' => 'application/vnd.groove-injector'
            ),
            'gtm' => array(
                'name' => 'Groove - Tool Message',
                'type' => 'application/vnd.groove-tool-message'
            ),
            'tpl' => array(
                'name' => 'Groove - Tool Template',
                'type' => 'application/vnd.groove-tool-template'
            ),
            'vcg' => array(
                'name' => 'Groove - Vcard',
                'type' => 'application/vnd.groove-vcard'
            ),
            'h261' => array(
                'name' => 'H.261',
                'type' => 'video/h261'
            ),
            'h263' => array(
                'name' => 'H.263',
                'type' => 'video/h263'
            ),
            'h264' => array(
                'name' => 'H.264',
                'type' => 'video/h264'
            ),
            'hpid' => array(
                'name' => 'Hewlett Packard Instant Delivery',
                'type' => 'application/vnd.hp-hpid'
            ),
            'hps' => array(
                'name' => 'Hewlett-Packard\'s WebPrintSmart',
                'type' => 'application/vnd.hp-hps'
            ),
            'hdf' => array(
                'name' => 'Hierarchical Data Format',
                'type' => 'application/x-hdf'
            ),
            'rip' => array(
                'name' => 'Hit\'n\'Mix',
                'type' => 'audio/vnd.rip'
            ),
            'hbci' => array(
                'name' => 'Homebanking Computer Interface (HBCI)',
                'type' => 'application/vnd.hbci'
            ),
            'jlt' => array(
                'name' => 'HP Indigo Digital Press - Job Layout Languate',
                'type' => 'application/vnd.hp-jlyt'
            ),
            'pcl' => array(
                'name' => 'HP Printer Command Language',
                'type' => 'application/vnd.hp-pcl'
            ),
            'hpgl' => array(
                'name' => 'HP-GL/2 and HP RTL',
                'type' => 'application/vnd.hp-hpgl'
            ),
            'hvs' => array(
                'name' => 'HV Script',
                'type' => 'application/vnd.yamaha.hv-script'
            ),
            'hvd' => array(
                'name' => 'HV Voice Dictionary',
                'type' => 'application/vnd.yamaha.hv-dic'
            ),
            'hvp' => array(
                'name' => 'HV Voice Parameter',
                'type' => 'application/vnd.yamaha.hv-voice'
            ),
            'sfd-hdstx' => array(
                'name' => 'Hydrostatix Master Suite',
                'type' => 'application/vnd.hydrostatix.sof-data'
            ),
            'stk' => array(
                'name' => 'Hyperstudio',
                'type' => 'application/hyperstudio'
            ),
            'hal' => array(
                'name' => 'Hypertext Application Language',
                'type' => 'application/vnd.hal+xml'
            ),
            'html' => array(
                'name' => 'HyperText Markup Language (HTML)',
                'type' => 'text/html'
            ),
            'irm' => array(
                'name' => 'IBM DB2 Rights Manager',
                'type' => 'application/vnd.ibm.rights-management'
            ),
            'sc' => array(
                'name' => 'IBM Electronic Media Management System - Secure Container',
                'type' => 'application/vnd.ibm.secure-container'
            ),
            'ics' => array(
                'name' => 'iCalendar',
                'type' => 'text/calendar'
            ),
            'icc' => array(
                'name' => 'ICC profile',
                'type' => 'application/vnd.iccprofile'
            ),
            'ico' => array(
                'name' => 'Icon Image',
                'type' => 'image/x-icon'
            ),
            'igl' => array(
                'name' => 'igLoader',
                'type' => 'application/vnd.igloader'
            ),
            'ief' => array(
                'name' => 'Image Exchange Format',
                'type' => 'image/ief'
            ),
            'ivp' => array(
                'name' => 'ImmerVision PURE Players',
                'type' => 'application/vnd.immervision-ivp'
            ),
            'ivu' => array(
                'name' => 'ImmerVision PURE Players',
                'type' => 'application/vnd.immervision-ivu'
            ),
            'rif' => array(
                'name' => 'IMS Networks',
                'type' => 'application/reginfo+xml'
            ),
            '3dml' => array(
                'name' => 'In3D - 3DML',
                'type' => 'text/vnd.in3d.3dml'
            ),
            'spot' => array(
                'name' => 'In3D - 3DML',
                'type' => 'text/vnd.in3d.spot'
            ),
            'igs' => array(
                'name' => 'Initial Graphics Exchange Specification (IGES)',
                'type' => 'model/iges'
            ),
            'i2g' => array(
                'name' => 'Interactive Geometry Software',
                'type' => 'application/vnd.intergeo'
            ),
            'cdy' => array(
                'name' => 'Interactive Geometry Software Cinderella',
                'type' => 'application/vnd.cinderella'
            ),
            'xpw' => array(
                'name' => 'Intercon FormNet',
                'type' => 'application/vnd.intercon.formnet'
            ),
            'fcs' => array(
                'name' => 'International Society for Advancement of Cytometry',
                'type' => 'application/vnd.isac.fcs'
            ),
            'ipfix' => array(
                'name' => 'Internet Protocol Flow Information Export',
                'type' => 'application/ipfix'
            ),
            'cer' => array(
                'name' => 'Internet Public Key Infrastructure - Certificate',
                'type' => 'application/pkix-cert'
            ),
            'pki' => array(
                'name' => 'Internet Public Key Infrastructure - Certificate Management Protocole',
                'type' => 'application/pkixcmp'
            ),
            'crl' => array(
                'name' => 'Internet Public Key Infrastructure - Certificate Revocation Lists',
                'type' => 'application/pkix-crl'
            ),
            'pkipath' => array(
                'name' => 'Internet Public Key Infrastructure - Certification Path',
                'type' => 'application/pkix-pkipath'
            ),
            'igm' => array(
                'name' => 'IOCOM Visimeet',
                'type' => 'application/vnd.insors.igm'
            ),
            'rcprofile' => array(
                'name' => 'IP Unplugged Roaming Client',
                'type' => 'application/vnd.ipunplugged.rcprofile'
            ),
            'irp' => array(
                'name' => 'iRepository / Lucidoc Editor',
                'type' => 'application/vnd.irepository.package+xml'
            ),
            'jad' => array(
                'name' => 'J2ME App Descriptor',
                'type' => 'text/vnd.sun.j2me.app-descriptor'
            ),
            'jar' => array(
                'name' => 'Java Archive',
                'type' => 'application/java-archive'
            ),
            'class' => array(
                'name' => 'Java Bytecode File',
                'type' => 'application/java-vm'
            ),
            'jnlp' => array(
                'name' => 'Java Network Launching Protocol',
                'type' => 'application/x-java-jnlp-file'
            ),
            'ser' => array(
                'name' => 'Java Serialized Object',
                'type' => 'application/java-serialized-object'
            ),
            'java' => array(
                'name' => 'Java Source File',
                'type' => '"text/x-java-source,java"'
            ),
            'js' => array(
                'name' => 'JavaScript',
                'type' => 'application/javascript'
            ),
            'json' => array(
                'name' => 'JavaScript Object Notation (JSON)',
                'type' => 'application/json'
            ),
            'joda' => array(
                'name' => 'Joda Archive',
                'type' => 'application/vnd.joost.joda-archive'
            ),
            'jpm' => array(
                'name' => 'JPEG 2000 Compound Image File Format',
                'type' => 'video/jpm'
            ),
            'jpgv' => array(
                'name' => 'JPGVideo',
                'type' => 'video/jpeg'
            ),
            'ktz' => array(
                'name' => 'Kahootz',
                'type' => 'application/vnd.kahootz'
            ),
            'mmd' => array(
                'name' => 'Karaoke on Chipnuts Chipsets',
                'type' => 'application/vnd.chipnuts.karaoke-mmd'
            ),
            'karbon' => array(
                'name' => 'KDE KOffice Office Suite - Karbon',
                'type' => 'application/vnd.kde.karbon'
            ),
            'chrt' => array(
                'name' => 'KDE KOffice Office Suite - KChart',
                'type' => 'application/vnd.kde.kchart'
            ),
            'kfo' => array(
                'name' => 'KDE KOffice Office Suite - Kformula',
                'type' => 'application/vnd.kde.kformula'
            ),
            'flw' => array(
                'name' => 'KDE KOffice Office Suite - Kivio',
                'type' => 'application/vnd.kde.kivio'
            ),
            'kon' => array(
                'name' => 'KDE KOffice Office Suite - Kontour',
                'type' => 'application/vnd.kde.kontour'
            ),
            'kpr' => array(
                'name' => 'KDE KOffice Office Suite - Kpresenter',
                'type' => 'application/vnd.kde.kpresenter'
            ),
            'ksp' => array(
                'name' => 'KDE KOffice Office Suite - Kspread',
                'type' => 'application/vnd.kde.kspread'
            ),
            'kwd' => array(
                'name' => 'KDE KOffice Office Suite - Kword',
                'type' => 'application/vnd.kde.kword'
            ),
            'htke' => array(
                'name' => 'Kenamea App',
                'type' => 'application/vnd.kenameaapp'
            ),
            'kia' => array(
                'name' => 'Kidspiration',
                'type' => 'application/vnd.kidspiration'
            ),
            'kne' => array(
                'name' => 'Kinar Applications',
                'type' => 'application/vnd.kinar'
            ),
            'sse' => array(
                'name' => 'Kodak Storyshare',
                'type' => 'application/vnd.kodak-descriptor'
            ),
            'lasxml' => array(
                'name' => 'Laser App Enterprise',
                'type' => 'application/vnd.las.las+xml'
            ),
            'latex' => array(
                'name' => 'LaTeX',
                'type' => 'application/x-latex'
            ),
            'lbd' => array(
                'name' => 'Life Balance - Desktop Edition',
                'type' => 'application/vnd.llamagraphics.life-balance.desktop'
            ),
            'lbe' => array(
                'name' => 'Life Balance - Exchange Format',
                'type' => 'application/vnd.llamagraphics.life-balance.exchange+xml'
            ),
            'jam' => array(
                'name' => 'Lightspeed Audio Lab',
                'type' => 'application/vnd.jam'
            ),
            '0.123' => array(
                'name' => 'Lotus 1-2-3',
                'type' => 'application/vnd.lotus-1-2-3'
            ),
            'apr' => array(
                'name' => 'Lotus Approach',
                'type' => 'application/vnd.lotus-approach'
            ),
            'pre' => array(
                'name' => 'Lotus Freelance',
                'type' => 'application/vnd.lotus-freelance'
            ),
            'nsf' => array(
                'name' => 'Lotus Notes',
                'type' => 'application/vnd.lotus-notes'
            ),
            'org' => array(
                'name' => 'Lotus Organizer',
                'type' => 'application/vnd.lotus-organizer'
            ),
            'scm' => array(
                'name' => 'Lotus Screencam',
                'type' => 'application/vnd.lotus-screencam'
            ),
            'lwp' => array(
                'name' => 'Lotus Wordpro',
                'type' => 'application/vnd.lotus-wordpro'
            ),
            'lvp' => array(
                'name' => 'Lucent Voice',
                'type' => 'audio/vnd.lucent.voice'
            ),
            'm3u' => array(
                'name' => 'M3U (Multimedia Playlist)',
                'type' => 'audio/x-mpegurl'
            ),
            'm4v' => array(
                'name' => 'M4v',
                'type' => 'video/x-m4v'
            ),
            'hqx' => array(
                'name' => 'Macintosh BinHex 4.0',
                'type' => 'application/mac-binhex40'
            ),
            'portpkg' => array(
                'name' => 'MacPorts Port System',
                'type' => 'application/vnd.macports.portpkg'
            ),
            'mgp' => array(
                'name' => 'MapGuide DBXML',
                'type' => 'application/vnd.osgeo.mapguide.package'
            ),
            'mrc' => array(
                'name' => 'MARC Formats',
                'type' => 'application/marc'
            ),
            'mrcx' => array(
                'name' => 'MARC21 XML Schema',
                'type' => 'application/marcxml+xml'
            ),
            'mxf' => array(
                'name' => 'Material Exchange Format',
                'type' => 'application/mxf'
            ),
            'nbp' => array(
                'name' => 'Mathematica Notebook Player',
                'type' => 'application/vnd.wolfram.player'
            ),
            'ma' => array(
                'name' => 'Mathematica Notebooks',
                'type' => 'application/mathematica'
            ),
            'mathml' => array(
                'name' => 'Mathematical Markup Language',
                'type' => 'application/mathml+xml'
            ),
            'mbox' => array(
                'name' => 'Mbox database files',
                'type' => 'application/mbox'
            ),
            'mc1' => array(
                'name' => 'MedCalc',
                'type' => 'application/vnd.medcalcdata'
            ),
            'mscml' => array(
                'name' => 'Media Server Control Markup Language',
                'type' => 'application/mediaservercontrol+xml'
            ),
            'cdkey' => array(
                'name' => 'MediaRemote',
                'type' => 'application/vnd.mediastation.cdkey'
            ),
            'mwf' => array(
                'name' => 'Medical Waveform Encoding Format',
                'type' => 'application/vnd.mfer'
            ),
            'mfm' => array(
                'name' => 'Melody Format for Mobile Platform',
                'type' => 'application/vnd.mfmp'
            ),
            'msh' => array(
                'name' => 'Mesh Data Type',
                'type' => 'model/mesh'
            ),
            'mads' => array(
                'name' => 'Metadata Authority  Description Schema',
                'type' => 'application/mads+xml'
            ),
            'mets' => array(
                'name' => 'Metadata Encoding and Transmission Standard',
                'type' => 'application/mets+xml'
            ),
            'mods' => array(
                'name' => 'Metadata Object Description Schema',
                'type' => 'application/mods+xml'
            ),
            'meta4' => array(
                'name' => 'Metalink',
                'type' => 'application/metalink4+xml'
            ),
            'potm' => array(
                'name' => 'Micosoft PowerPoint - Macro-Enabled Template File',
                'type' => 'application/vnd.ms-powerpoint.template.macroenabled.12'
            ),
            'docm' => array(
                'name' => 'Micosoft Word - Macro-Enabled Document',
                'type' => 'application/vnd.ms-word.document.macroenabled.12'
            ),
            'dotm' => array(
                'name' => 'Micosoft Word - Macro-Enabled Template',
                'type' => 'application/vnd.ms-word.template.macroenabled.12'
            ),
            'mcd' => array(
                'name' => 'Micro CADAM Helix D&D',
                'type' => 'application/vnd.mcd'
            ),
            'flo' => array(
                'name' => 'Micrografx',
                'type' => 'application/vnd.micrografx.flo'
            ),
            'igx' => array(
                'name' => 'Micrografx iGrafx Professional',
                'type' => 'application/vnd.micrografx.igx'
            ),
            'es3' => array(
                'name' => 'MICROSEC e-Szign¢',
                'type' => 'application/vnd.eszigno3+xml'
            ),
            'mdb' => array(
                'name' => 'Microsoft Access',
                'type' => 'application/x-msaccess'
            ),
            'asf' => array(
                'name' => 'Microsoft Advanced Systems Format (ASF)',
                'type' => 'video/x-ms-asf'
            ),
            'exe' => array(
                'name' => 'Microsoft Application',
                'type' => 'application/x-msdownload'
            ),
            'cil' => array(
                'name' => 'Microsoft Artgalry',
                'type' => 'application/vnd.ms-artgalry'
            ),
            'cab' => array(
                'name' => 'Microsoft Cabinet File',
                'type' => 'application/vnd.ms-cab-compressed'
            ),
            'ims' => array(
                'name' => 'Microsoft Class Server',
                'type' => 'application/vnd.ms-ims'
            ),
            'application' => array(
                'name' => 'Microsoft ClickOnce',
                'type' => 'application/x-ms-application'
            ),
            'clp' => array(
                'name' => 'Microsoft Clipboard Clip',
                'type' => 'application/x-msclip'
            ),
            'mdi' => array(
                'name' => 'Microsoft Document Imaging Format',
                'type' => 'image/vnd.ms-modi'
            ),
            'eot' => array(
                'name' => 'Microsoft Embedded OpenType',
                'type' => 'application/vnd.ms-fontobject'
            ),
            'xlam' => array(
                'name' => 'Microsoft Excel - Add-In File',
                'type' => 'application/vnd.ms-excel.addin.macroenabled.12'
            ),
            'xlsb' => array(
                'name' => 'Microsoft Excel - Binary Workbook',
                'type' => 'application/vnd.ms-excel.sheet.binary.macroenabled.12'
            ),
            'xltm' => array(
                'name' => 'Microsoft Excel - Macro-Enabled Template File',
                'type' => 'application/vnd.ms-excel.template.macroenabled.12'
            ),
            'xlsm' => array(
                'name' => 'Microsoft Excel - Macro-Enabled Workbook',
                'type' => 'application/vnd.ms-excel.sheet.macroenabled.12'
            ),
            'chm' => array(
                'name' => 'Microsoft Html Help File',
                'type' => 'application/vnd.ms-htmlhelp'
            ),
            'crd' => array(
                'name' => 'Microsoft Information Card',
                'type' => 'application/x-mscardfile'
            ),
            'lrm' => array(
                'name' => 'Microsoft Learning Resource Module',
                'type' => 'application/vnd.ms-lrm'
            ),
            'mvb' => array(
                'name' => 'Microsoft MediaView',
                'type' => 'application/x-msmediaview'
            ),
            'mny' => array(
                'name' => 'Microsoft Money',
                'type' => 'application/x-msmoney'
            ),
            'sldx' => array(
                'name' => 'Microsoft Office - OOXML - Presentation (Slide)',
                'type' => 'application/vnd.openxmlformats-officedocument.presentationml.slide'
            ),
            'ppsx' => array(
                'name' => 'Microsoft Office - OOXML - Presentation (Slideshow)',
                'type' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow'
            ),
            'potx' => array(
                'name' => 'Microsoft Office - OOXML - Presentation Template',
                'type' => 'application/vnd.openxmlformats-officedocument.presentationml.template'
            ),
            'xltx' => array(
                'name' => 'Microsoft Office - OOXML - Spreadsheet Teplate',
                'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template'
            ),
            'dotx' => array(
                'name' => 'Microsoft Office - OOXML - Word Document Template',
                'type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'
            ),
            'obd' => array(
                'name' => 'Microsoft Office Binder',
                'type' => 'application/x-msbinder'
            ),
            'thmx' => array(
                'name' => 'Microsoft Office System Release Theme',
                'type' => 'application/vnd.ms-officetheme'
            ),
            'onetoc' => array(
                'name' => 'Microsoft OneNote',
                'type' => 'application/onenote'
            ),
            'pya' => array(
                'name' => 'Microsoft PlayReady Ecosystem',
                'type' => 'audio/vnd.ms-playready.media.pya'
            ),
            'pyv' => array(
                'name' => 'Microsoft PlayReady Ecosystem Video',
                'type' => 'video/vnd.ms-playready.media.pyv'
            ),
            'ppam' => array(
                'name' => 'Microsoft PowerPoint - Add-in file',
                'type' => 'application/vnd.ms-powerpoint.addin.macroenabled.12'
            ),
            'sldm' => array(
                'name' => 'Microsoft PowerPoint - Macro-Enabled Open XML Slide',
                'type' => 'application/vnd.ms-powerpoint.slide.macroenabled.12'
            ),
            'pptm' => array(
                'name' => 'Microsoft PowerPoint - Macro-Enabled Presentation File',
                'type' => 'application/vnd.ms-powerpoint.presentation.macroenabled.12'
            ),
            'ppsm' => array(
                'name' => 'Microsoft PowerPoint - Macro-Enabled Slide Show File',
                'type' => 'application/vnd.ms-powerpoint.slideshow.macroenabled.12'
            ),
            'mpp' => array(
                'name' => 'Microsoft Project',
                'type' => 'application/vnd.ms-project'
            ),
            'pub' => array(
                'name' => 'Microsoft Publisher',
                'type' => 'application/x-mspublisher'
            ),
            'scd' => array(
                'name' => 'Microsoft Schedule+',
                'type' => 'application/x-msschedule'
            ),
            'xap' => array(
                'name' => 'Microsoft Silverlight',
                'type' => 'application/x-silverlight-app'
            ),
            'stl' => array(
                'name' => 'Microsoft Trust UI Provider - Certificate Trust Link',
                'type' => 'application/vnd.ms-pki.stl'
            ),
            'cat' => array(
                'name' => 'Microsoft Trust UI Provider - Security Catalog',
                'type' => 'application/vnd.ms-pki.seccat'
            ),
            'vsd' => array(
                'name' => 'Microsoft Visio',
                'type' => 'application/vnd.visio'
            ),
            'wm' => array(
                'name' => 'Microsoft Windows Media',
                'type' => 'video/x-ms-wm'
            ),
            'wma' => array(
                'name' => 'Microsoft Windows Media Audio',
                'type' => 'audio/x-ms-wma'
            ),
            'wax' => array(
                'name' => 'Microsoft Windows Media Audio Redirector',
                'type' => 'audio/x-ms-wax'
            ),
            'wmx' => array(
                'name' => 'Microsoft Windows Media Audio/Video Playlist',
                'type' => 'video/x-ms-wmx'
            ),
            'wmd' => array(
                'name' => 'Microsoft Windows Media Player Download Package',
                'type' => 'application/x-ms-wmd'
            ),
            'wpl' => array(
                'name' => 'Microsoft Windows Media Player Playlist',
                'type' => 'application/vnd.ms-wpl'
            ),
            'wmz' => array(
                'name' => 'Microsoft Windows Media Player Skin Package',
                'type' => 'application/x-ms-wmz'
            ),
            'wmv' => array(
                'name' => 'Microsoft Windows Media Video',
                'type' => 'video/x-ms-wmv'
            ),
            'wvx' => array(
                'name' => 'Microsoft Windows Media Video Playlist',
                'type' => 'video/x-ms-wvx'
            ),
            'wmf' => array(
                'name' => 'Microsoft Windows Metafile',
                'type' => 'application/x-msmetafile'
            ),
            'trm' => array(
                'name' => 'Microsoft Windows Terminal Services',
                'type' => 'application/x-msterminal'
            ),
            'wri' => array(
                'name' => 'Microsoft Wordpad',
                'type' => 'application/x-mswrite'
            ),
            'wps' => array(
                'name' => 'Microsoft Works',
                'type' => 'application/vnd.ms-works'
            ),
            'xbap' => array(
                'name' => 'Microsoft XAML Browser Application',
                'type' => 'application/x-ms-xbap'
            ),
            'xps' => array(
                'name' => 'Microsoft XML Paper Specification',
                'type' => 'application/vnd.ms-xpsdocument'
            ),
            'mid' => array(
                'name' => 'MIDI - Musical Instrument Digital Interface',
                'type' => 'audio/midi'
            ),
            'mpy' => array(
                'name' => 'MiniPay',
                'type' => 'application/vnd.ibm.minipay'
            ),
            'afp' => array(
                'name' => 'MO:DCA-P',
                'type' => 'application/vnd.ibm.modcap'
            ),
            'rms' => array(
                'name' => 'Mobile Information Device Profile',
                'type' => 'application/vnd.jcp.javame.midlet-rms'
            ),
            'tmo' => array(
                'name' => 'MobileTV',
                'type' => 'application/vnd.tmobile-livetv'
            ),
            'prc' => array(
                'name' => 'Mobipocket',
                'type' => 'application/x-mobipocket-ebook'
            ),
            'mbk' => array(
                'name' => 'Mobius Management Systems - Basket file',
                'type' => 'application/vnd.mobius.mbk'
            ),
            'dis' => array(
                'name' => 'Mobius Management Systems - Distribution Database',
                'type' => 'application/vnd.mobius.dis'
            ),
            'plc' => array(
                'name' => 'Mobius Management Systems - Policy Definition Language File',
                'type' => 'application/vnd.mobius.plc'
            ),
            'mqy' => array(
                'name' => 'Mobius Management Systems - Query File',
                'type' => 'application/vnd.mobius.mqy'
            ),
            'msl' => array(
                'name' => 'Mobius Management Systems - Script Language',
                'type' => 'application/vnd.mobius.msl'
            ),
            'txf' => array(
                'name' => 'Mobius Management Systems - Topic Index File',
                'type' => 'application/vnd.mobius.txf'
            ),
            'daf' => array(
                'name' => 'Mobius Management Systems - UniversalArchive',
                'type' => 'application/vnd.mobius.daf'
            ),
            'fly' => array(
                'name' => 'mod_fly / fly.cgi',
                'type' => 'text/vnd.fly'
            ),
            'mpc' => array(
                'name' => 'Mophun Certificate',
                'type' => 'application/vnd.mophun.certificate'
            ),
            'mpn' => array(
                'name' => 'Mophun VM',
                'type' => 'application/vnd.mophun.application'
            ),
            'mj2' => array(
                'name' => 'Motion JPEG 2000',
                'type' => 'video/mj2'
            ),
            'mpga' => array(
                'name' => 'MPEG Audio',
                'type' => 'audio/mpeg'
            ),
            'mxu' => array(
                'name' => 'MPEG Url',
                'type' => 'video/vnd.mpegurl'
            ),
            'mpeg' => array(
                'name' => 'MPEG Video',
                'type' => 'video/mpeg'
            ),
            'm21' => array(
                'name' => 'MPEG-21',
                'type' => 'application/mp21'
            ),
            'mp4a' => array(
                'name' => 'MPEG-4 Audio',
                'type' => 'audio/mp4'
            ),
            'm3u8' => array(
                'name' => 'Multimedia Playlist Unicode',
                'type' => 'application/vnd.apple.mpegurl'
            ),
            'mus' => array(
                'name' => 'MUsical Score Interpreted Code Invented  for the ASCII designation of Notation',
                'type' => 'application/vnd.musician'
            ),
            'msty' => array(
                'name' => 'Muvee Automatic Video Editing',
                'type' => 'application/vnd.muvee.style'
            ),
            'mxml' => array(
                'name' => 'MXML',
                'type' => 'application/xv+xml'
            ),
            'ngdat' => array(
                'name' => 'N-Gage Game Data',
                'type' => 'application/vnd.nokia.n-gage.data'
            ),
            'n-gage' => array(
                'name' => 'N-Gage Game Installer',
                'type' => 'application/vnd.nokia.n-gage.symbian.install'
            ),
            'ncx' => array(
                'name' => 'Navigation Control file for XML (for ePub)',
                'type' => 'application/x-dtbncx+xml'
            ),
            'nc' => array(
                'name' => 'Network Common Data Form (NetCDF)',
                'type' => 'application/x-netcdf'
            ),
            'nlu' => array(
                'name' => 'neuroLanguage',
                'type' => 'application/vnd.neurolanguage.nlu'
            ),
            'dna' => array(
                'name' => 'New Moon Liftoff/DNA',
                'type' => 'application/vnd.dna'
            ),
            'nnd' => array(
                'name' => 'NobleNet Directory',
                'type' => 'application/vnd.noblenet-directory'
            ),
            'nns' => array(
                'name' => 'NobleNet Sealer',
                'type' => 'application/vnd.noblenet-sealer'
            ),
            'nnw' => array(
                'name' => 'NobleNet Web',
                'type' => 'application/vnd.noblenet-web'
            ),
            'rpst' => array(
                'name' => 'Nokia Radio Application - Preset',
                'type' => 'application/vnd.nokia.radio-preset'
            ),
            'rpss' => array(
                'name' => 'Nokia Radio Application - Preset',
                'type' => 'application/vnd.nokia.radio-presets'
            ),
            'n3' => array(
                'name' => 'Notation3',
                'type' => 'text/n3'
            ),
            'edm' => array(
                'name' => 'Novadigm\'s RADIA and EDM products',
                'type' => 'application/vnd.novadigm.edm'
            ),
            'edx' => array(
                'name' => 'Novadigm\'s RADIA and EDM products',
                'type' => 'application/vnd.novadigm.edx'
            ),
            'ext' => array(
                'name' => 'Novadigm\'s RADIA and EDM products',
                'type' => 'application/vnd.novadigm.ext'
            ),
            'gph' => array(
                'name' => 'NpGraphIt',
                'type' => 'application/vnd.flographit'
            ),
            'ecelp4800' => array(
                'name' => 'Nuera ECELP 4800',
                'type' => 'audio/vnd.nuera.ecelp4800'
            ),
            'ecelp7470' => array(
                'name' => 'Nuera ECELP 7470',
                'type' => 'audio/vnd.nuera.ecelp7470'
            ),
            'ecelp9600' => array(
                'name' => 'Nuera ECELP 9600',
                'type' => 'audio/vnd.nuera.ecelp9600'
            ),
            'oda' => array(
                'name' => 'Office Document Architecture',
                'type' => 'application/oda'
            ),
            'oga' => array(
                'name' => 'Ogg Audio',
                'type' => 'audio/ogg'
            ),
            'ogv' => array(
                'name' => 'Ogg Video',
                'type' => 'video/ogg'
            ),
            'dd2' => array(
                'name' => 'OMA Download Agents',
                'type' => 'application/vnd.oma.dd2+xml'
            ),
            'oth' => array(
                'name' => 'Open Document Text Web',
                'type' => 'application/vnd.oasis.opendocument.text-web'
            ),
            'opf' => array(
                'name' => 'Open eBook Publication Structure',
                'type' => 'application/oebps-package+xml'
            ),
            'qbo' => array(
                'name' => 'Open Financial Exchange',
                'type' => 'application/vnd.intu.qbo'
            ),
            'oxt' => array(
                'name' => 'Open Office Extension',
                'type' => 'application/vnd.openofficeorg.extension'
            ),
            'osf' => array(
                'name' => 'Open Score Format',
                'type' => 'application/vnd.yamaha.openscoreformat'
            ),
            'weba' => array(
                'name' => 'Open Web Media Project - Audio',
                'type' => 'audio/webm'
            ),
            'webm' => array(
                'name' => 'Open Web Media Project - Video',
                'type' => 'video/webm'
            ),
            'odc' => array(
                'name' => 'OpenDocument Chart',
                'type' => 'application/vnd.oasis.opendocument.chart'
            ),
            'otc' => array(
                'name' => 'OpenDocument Chart Template',
                'type' => 'application/vnd.oasis.opendocument.chart-template'
            ),
            'odb' => array(
                'name' => 'OpenDocument Database',
                'type' => 'application/vnd.oasis.opendocument.database'
            ),
            'odf' => array(
                'name' => 'OpenDocument Formula',
                'type' => 'application/vnd.oasis.opendocument.formula'
            ),
            'odft' => array(
                'name' => 'OpenDocument Formula Template',
                'type' => 'application/vnd.oasis.opendocument.formula-template'
            ),
            'odg' => array(
                'name' => 'OpenDocument Graphics',
                'type' => 'application/vnd.oasis.opendocument.graphics'
            ),
            'otg' => array(
                'name' => 'OpenDocument Graphics Template',
                'type' => 'application/vnd.oasis.opendocument.graphics-template'
            ),
            'odi' => array(
                'name' => 'OpenDocument Image',
                'type' => 'application/vnd.oasis.opendocument.image'
            ),
            'oti' => array(
                'name' => 'OpenDocument Image Template',
                'type' => 'application/vnd.oasis.opendocument.image-template'
            ),
            'odp' => array(
                'name' => 'OpenDocument Presentation',
                'type' => 'application/vnd.oasis.opendocument.presentation'
            ),
            'otp' => array(
                'name' => 'OpenDocument Presentation Template',
                'type' => 'application/vnd.oasis.opendocument.presentation-template'
            ),
            'ods' => array(
                'name' => 'OpenDocument Spreadsheet',
                'type' => 'application/vnd.oasis.opendocument.spreadsheet'
            ),
            'ots' => array(
                'name' => 'OpenDocument Spreadsheet Template',
                'type' => 'application/vnd.oasis.opendocument.spreadsheet-template'
            ),
            'odt' => array(
                'name' => 'OpenDocument Text',
                'type' => 'application/vnd.oasis.opendocument.text'
            ),
            'odm' => array(
                'name' => 'OpenDocument Text Master',
                'type' => 'application/vnd.oasis.opendocument.text-master'
            ),
            'ott' => array(
                'name' => 'OpenDocument Text Template',
                'type' => 'application/vnd.oasis.opendocument.text-template'
            ),
            'ktx' => array(
                'name' => 'OpenGL Textures (KTX)',
                'type' => 'image/ktx'
            ),
            'sxc' => array(
                'name' => 'OpenOffice - Calc (Spreadsheet)',
                'type' => 'application/vnd.sun.xml.calc'
            ),
            'stc' => array(
                'name' => 'OpenOffice - Calc Template (Spreadsheet)',
                'type' => 'application/vnd.sun.xml.calc.template'
            ),
            'sxd' => array(
                'name' => 'OpenOffice - Draw (Graphics)',
                'type' => 'application/vnd.sun.xml.draw'
            ),
            'std' => array(
                'name' => 'OpenOffice - Draw Template (Graphics)',
                'type' => 'application/vnd.sun.xml.draw.template'
            ),
            'sxi' => array(
                'name' => 'OpenOffice - Impress (Presentation)',
                'type' => 'application/vnd.sun.xml.impress'
            ),
            'sti' => array(
                'name' => 'OpenOffice - Impress Template (Presentation)',
                'type' => 'application/vnd.sun.xml.impress.template'
            ),
            'sxm' => array(
                'name' => 'OpenOffice - Math (Formula)',
                'type' => 'application/vnd.sun.xml.math'
            ),
            'sxw' => array(
                'name' => 'OpenOffice - Writer (Text - HTML)',
                'type' => 'application/vnd.sun.xml.writer'
            ),
            'sxg' => array(
                'name' => 'OpenOffice - Writer (Text - HTML)',
                'type' => 'application/vnd.sun.xml.writer.global'
            ),
            'stw' => array(
                'name' => 'OpenOffice - Writer Template (Text - HTML)',
                'type' => 'application/vnd.sun.xml.writer.template'
            ),
            'otf' => array(
                'name' => 'OpenType Font File',
                'type' => 'application/x-font-otf'
            ),
            'osfpvg' => array(
                'name' => 'OSFPVG',
                'type' => 'application/vnd.yamaha.openscoreformat.osfpvg+xml'
            ),
            'dp' => array(
                'name' => 'OSGi Deployment Package',
                'type' => 'application/vnd.osgi.dp'
            ),
            'pdb' => array(
                'name' => 'PalmOS Data',
                'type' => 'application/vnd.palm'
            ),
            'p' => array(
                'name' => 'Pascal Source File',
                'type' => 'text/x-pascal'
            ),
            'paw' => array(
                'name' => 'PawaaFILE',
                'type' => 'application/vnd.pawaafile'
            ),
            'pclxl' => array(
                'name' => 'PCL 6 Enhanced (Formely PCL XL)',
                'type' => 'application/vnd.hp-pclxl'
            ),
            'efif' => array(
                'name' => 'Pcsel eFIF File',
                'type' => 'application/vnd.picsel'
            ),
            'pcx' => array(
                'name' => 'PCX Image',
                'type' => 'image/x-pcx'
            ),
            'psd' => array(
                'name' => 'Photoshop Document',
                'type' => 'image/vnd.adobe.photoshop'
            ),
            'prf' => array(
                'name' => 'PICSRules',
                'type' => 'application/pics-rules'
            ),
            'pic' => array(
                'name' => 'PICT Image',
                'type' => 'image/x-pict'
            ),
            'chat' => array(
                'name' => 'pIRCh',
                'type' => 'application/x-chat'
            ),
            'p10' => array(
                'name' => 'PKCS #10 - Certification Request Standard',
                'type' => 'application/pkcs10'
            ),
            'p12' => array(
                'name' => 'PKCS #12 - Personal Information Exchange Syntax Standard',
                'type' => 'application/x-pkcs12'
            ),
            'p7m' => array(
                'name' => 'PKCS #7 - Cryptographic Message Syntax Standard',
                'type' => 'application/pkcs7-mime'
            ),
            'p7s' => array(
                'name' => 'PKCS #7 - Cryptographic Message Syntax Standard',
                'type' => 'application/pkcs7-signature'
            ),
            'p7r' => array(
                'name' => 'PKCS #7 - Cryptographic Message Syntax Standard (Certificate Request Response)',
                'type' => 'application/x-pkcs7-certreqresp'
            ),
            'p7b' => array(
                'name' => 'PKCS #7 - Cryptographic Message Syntax Standard (Certificates)',
                'type' => 'application/x-pkcs7-certificates'
            ),
            'p8' => array(
                'name' => 'PKCS #8 - Private-Key Information Syntax Standard',
                'type' => 'application/pkcs8'
            ),
            'plf' => array(
                'name' => 'PocketLearn Viewers',
                'type' => 'application/vnd.pocketlearn'
            ),
            'pnm' => array(
                'name' => 'Portable Anymap Image',
                'type' => 'image/x-portable-anymap'
            ),
            'pbm' => array(
                'name' => 'Portable Bitmap Format',
                'type' => 'image/x-portable-bitmap'
            ),
            'pcf' => array(
                'name' => 'Portable Compiled Format',
                'type' => 'application/x-font-pcf'
            ),
            'pfr' => array(
                'name' => 'Portable Font Resource',
                'type' => 'application/font-tdpfr'
            ),
            'pgn' => array(
                'name' => 'Portable Game Notation (Chess Games)',
                'type' => 'application/x-chess-pgn'
            ),
            'pgm' => array(
                'name' => 'Portable Graymap Format',
                'type' => 'image/x-portable-graymap'
            ),
            'ppm' => array(
                'name' => 'Portable Pixmap Format',
                'type' => 'image/x-portable-pixmap'
            ),
            'pskcxml' => array(
                'name' => 'Portable Symmetric Key Container',
                'type' => 'application/pskc+xml'
            ),
            'pml' => array(
                'name' => 'PosML',
                'type' => 'application/vnd.ctc-posml'
            ),
            'ai' => array(
                'name' => 'PostScript',
                'type' => 'application/postscript'
            ),
            'pfa' => array(
                'name' => 'PostScript Fonts',
                'type' => 'application/x-font-type1'
            ),
            'pbd' => array(
                'name' => 'PowerBuilder',
                'type' => 'application/vnd.powerbuilder6'
            ),
            '' => array(
                'name' => 'Pretty Good Privacy',
                'type' => 'application/pgp-encrypted'
            ),
            'pgp' => array(
                'name' => 'Pretty Good Privacy - Signature',
                'type' => 'application/pgp-signature'
            ),
            'box' => array(
                'name' => 'Preview Systems ZipLock/VBox',
                'type' => 'application/vnd.previewsystems.box'
            ),
            'ptid' => array(
                'name' => 'Princeton Video Image',
                'type' => 'application/vnd.pvi.ptid1'
            ),
            'pls' => array(
                'name' => 'Pronunciation Lexicon Specification',
                'type' => 'application/pls+xml'
            ),
            'str' => array(
                'name' => 'Proprietary P&G Standard Reporting System',
                'type' => 'application/vnd.pg.format'
            ),
            'ei6' => array(
                'name' => 'Proprietary P&G Standard Reporting System',
                'type' => 'application/vnd.pg.osasli'
            ),
            'dsc' => array(
                'name' => 'PRS Lines Tag',
                'type' => 'text/prs.lines.tag'
            ),
            'psf' => array(
                'name' => 'PSF Fonts',
                'type' => 'application/x-font-linux-psf'
            ),
            'qps' => array(
                'name' => 'PubliShare Objects',
                'type' => 'application/vnd.publishare-delta-tree'
            ),
            'wg' => array(
                'name' => 'Qualcomm\'s Plaza Mobile Internet',
                'type' => 'application/vnd.pmi.widget'
            ),
            'qxd' => array(
                'name' => 'QuarkXpress',
                'type' => 'application/vnd.quark.quarkxpress'
            ),
            'esf' => array(
                'name' => 'QUASS Stream Player',
                'type' => 'application/vnd.epson.esf'
            ),
            'msf' => array(
                'name' => 'QUASS Stream Player',
                'type' => 'application/vnd.epson.msf'
            ),
            'ssf' => array(
                'name' => 'QUASS Stream Player',
                'type' => 'application/vnd.epson.ssf'
            ),
            'qam' => array(
                'name' => 'QuickAnime Player',
                'type' => 'application/vnd.epson.quickanime'
            ),
            'qfx' => array(
                'name' => 'Quicken',
                'type' => 'application/vnd.intu.qfx'
            ),
            'qt' => array(
                'name' => 'Quicktime Video',
                'type' => 'video/quicktime'
            ),
            'rar' => array(
                'name' => 'RAR Archive',
                'type' => 'application/x-rar-compressed'
            ),
            'ram' => array(
                'name' => 'Real Audio Sound',
                'type' => 'audio/x-pn-realaudio'
            ),
            'rmp' => array(
                'name' => 'Real Audio Sound',
                'type' => 'audio/x-pn-realaudio-plugin'
            ),
            'rsd' => array(
                'name' => 'Really Simple Discovery',
                'type' => 'application/rsd+xml'
            ),
            'rm' => array(
                'name' => 'RealMedia',
                'type' => 'application/vnd.rn-realmedia'
            ),
            'bed' => array(
                'name' => 'RealVNC',
                'type' => 'application/vnd.realvnc.bed'
            ),
            'mxl' => array(
                'name' => 'Recordare Applications',
                'type' => 'application/vnd.recordare.musicxml'
            ),
            'musicxml' => array(
                'name' => 'Recordare Applications',
                'type' => 'application/vnd.recordare.musicxml+xml'
            ),
            'rnc' => array(
                'name' => 'Relax NG Compact Syntax',
                'type' => 'application/relax-ng-compact-syntax'
            ),
            'rdz' => array(
                'name' => 'RemoteDocs R-Viewer',
                'type' => 'application/vnd.data-vision.rdz'
            ),
            'rdf' => array(
                'name' => 'Resource Description Framework',
                'type' => 'application/rdf+xml'
            ),
            'rp9' => array(
                'name' => 'RetroPlatform Player',
                'type' => 'application/vnd.cloanto.rp9'
            ),
            'jisp' => array(
                'name' => 'RhymBox',
                'type' => 'application/vnd.jisp'
            ),
            'rtf' => array(
                'name' => 'Rich Text Format',
                'type' => 'application/rtf'
            ),
            'rtx' => array(
                'name' => 'Rich Text Format (RTF)',
                'type' => 'text/richtext'
            ),
            'link66' => array(
                'name' => 'ROUTE 66 Location Based Services',
                'type' => 'application/vnd.route66.link66+xml'
            ),
            '".rss, .xml"' => array(
                'name' => 'RSS - Really Simple Syndication',
                'type' => 'application/rss+xml'
            ),
            'shf' => array(
                'name' => 'S Hexdump Format',
                'type' => 'application/shf+xml'
            ),
            'st' => array(
                'name' => 'SailingTracker',
                'type' => 'application/vnd.sailingtracker.track'
            ),
            'svg' => array(
                'name' => 'Scalable Vector Graphics (SVG)',
                'type' => 'image/svg+xml'
            ),
            'sus' => array(
                'name' => 'ScheduleUs',
                'type' => 'application/vnd.sus-calendar'
            ),
            'sru' => array(
                'name' => 'Search/Retrieve via URL Response Format',
                'type' => 'application/sru+xml'
            ),
            'setpay' => array(
                'name' => 'Secure Electronic Transaction - Payment',
                'type' => 'application/set-payment-initiation'
            ),
            'setreg' => array(
                'name' => 'Secure Electronic Transaction - Registration',
                'type' => 'application/set-registration-initiation'
            ),
            'sema' => array(
                'name' => 'Secured eMail',
                'type' => 'application/vnd.sema'
            ),
            'semd' => array(
                'name' => 'Secured eMail',
                'type' => 'application/vnd.semd'
            ),
            'semf' => array(
                'name' => 'Secured eMail',
                'type' => 'application/vnd.semf'
            ),
            'see' => array(
                'name' => 'SeeMail',
                'type' => 'application/vnd.seemail'
            ),
            'snf' => array(
                'name' => 'Server Normal Format',
                'type' => 'application/x-font-snf'
            ),
            'spq' => array(
                'name' => 'Server-Based Certificate Validation Protocol - Validation Policies - Request',
                'type' => 'application/scvp-vp-request'
            ),
            'spp' => array(
                'name' => 'Server-Based Certificate Validation Protocol - Validation Policies - Response',
                'type' => 'application/scvp-vp-response'
            ),
            'scq' => array(
                'name' => 'Server-Based Certificate Validation Protocol - Validation Request',
                'type' => 'application/scvp-cv-request'
            ),
            'scs' => array(
                'name' => 'Server-Based Certificate Validation Protocol - Validation Response',
                'type' => 'application/scvp-cv-response'
            ),
            'sdp' => array(
                'name' => 'Session Description Protocol',
                'type' => 'application/sdp'
            ),
            'etx' => array(
                'name' => 'Setext',
                'type' => 'text/x-setext'
            ),
            'movie' => array(
                'name' => 'SGI Movie',
                'type' => 'video/x-sgi-movie'
            ),
            'ifm' => array(
                'name' => 'Shana Informed Filler',
                'type' => 'application/vnd.shana.informed.formdata'
            ),
            'itp' => array(
                'name' => 'Shana Informed Filler',
                'type' => 'application/vnd.shana.informed.formtemplate'
            ),
            'iif' => array(
                'name' => 'Shana Informed Filler',
                'type' => 'application/vnd.shana.informed.interchange'
            ),
            'ipk' => array(
                'name' => 'Shana Informed Filler',
                'type' => 'application/vnd.shana.informed.package'
            ),
            'tfi' => array(
                'name' => 'Sharing Transaction Fraud Data',
                'type' => 'application/thraud+xml'
            ),
            'shar' => array(
                'name' => 'Shell Archive',
                'type' => 'application/x-shar'
            ),
            'rgb' => array(
                'name' => 'Silicon Graphics RGB Bitmap',
                'type' => 'image/x-rgb'
            ),
            'slt' => array(
                'name' => 'SimpleAnimeLite Player',
                'type' => 'application/vnd.epson.salt'
            ),
            'aso' => array(
                'name' => 'Simply Accounting',
                'type' => 'application/vnd.accpac.simply.aso'
            ),
            'imp' => array(
                'name' => 'Simply Accounting - Data Import',
                'type' => 'application/vnd.accpac.simply.imp'
            ),
            'twd' => array(
                'name' => 'SimTech MindMapper',
                'type' => 'application/vnd.simtech-mindmapper'
            ),
            'csp' => array(
                'name' => 'Sixth Floor Media - CommonSpace',
                'type' => 'application/vnd.commonspace'
            ),
            'saf' => array(
                'name' => 'SMAF Audio',
                'type' => 'application/vnd.yamaha.smaf-audio'
            ),
            'mmf' => array(
                'name' => 'SMAF File',
                'type' => 'application/vnd.smaf'
            ),
            'spf' => array(
                'name' => 'SMAF Phrase',
                'type' => 'application/vnd.yamaha.smaf-phrase'
            ),
            'teacher' => array(
                'name' => 'SMART Technologies Apps',
                'type' => 'application/vnd.smart.teacher'
            ),
            'svd' => array(
                'name' => 'SourceView Document',
                'type' => 'application/vnd.svd'
            ),
            'rq' => array(
                'name' => 'SPARQL - Query',
                'type' => 'application/sparql-query'
            ),
            'srx' => array(
                'name' => 'SPARQL - Results',
                'type' => 'application/sparql-results+xml'
            ),
            'gram' => array(
                'name' => 'Speech Recognition Grammar Specification',
                'type' => 'application/srgs'
            ),
            'grxml' => array(
                'name' => 'Speech Recognition Grammar Specification - XML',
                'type' => 'application/srgs+xml'
            ),
            'ssml' => array(
                'name' => 'Speech Synthesis Markup Language',
                'type' => 'application/ssml+xml'
            ),
            'skp' => array(
                'name' => 'SSEYO Koan Play File',
                'type' => 'application/vnd.koan'
            ),
            'sgml' => array(
                'name' => 'Standard Generalized Markup Language (SGML)',
                'type' => 'text/sgml'
            ),
            'sdc' => array(
                'name' => 'StarOffice - Calc',
                'type' => 'application/vnd.stardivision.calc'
            ),
            'sda' => array(
                'name' => 'StarOffice - Draw',
                'type' => 'application/vnd.stardivision.draw'
            ),
            'sdd' => array(
                'name' => 'StarOffice - Impress',
                'type' => 'application/vnd.stardivision.impress'
            ),
            'smf' => array(
                'name' => 'StarOffice - Math',
                'type' => 'application/vnd.stardivision.math'
            ),
            'sdw' => array(
                'name' => 'StarOffice - Writer',
                'type' => 'application/vnd.stardivision.writer'
            ),
            'sgl' => array(
                'name' => 'StarOffice - Writer  (Global)',
                'type' => 'application/vnd.stardivision.writer-global'
            ),
            'sm' => array(
                'name' => 'StepMania',
                'type' => 'application/vnd.stepmania.stepchart'
            ),
            'sit' => array(
                'name' => 'Stuffit Archive',
                'type' => 'application/x-stuffit'
            ),
            'sitx' => array(
                'name' => 'Stuffit Archive',
                'type' => 'application/x-stuffitx'
            ),
            'sdkm' => array(
                'name' => 'SudokuMagic',
                'type' => 'application/vnd.solent.sdkm+xml'
            ),
            'xo' => array(
                'name' => 'Sugar Linux Application Bundle',
                'type' => 'application/vnd.olpc-sugar'
            ),
            'au' => array(
                'name' => 'Sun Audio - Au file format',
                'type' => 'audio/basic'
            ),
            'wqd' => array(
                'name' => 'SundaHus WQ',
                'type' => 'application/vnd.wqd'
            ),
            'sis' => array(
                'name' => 'Symbian Install Package',
                'type' => 'application/vnd.symbian.install'
            ),
            'smi' => array(
                'name' => 'Synchronized Multimedia Integration Language',
                'type' => 'application/smil+xml'
            ),
            'xsm' => array(
                'name' => 'SyncML',
                'type' => 'application/vnd.syncml+xml'
            ),
            'bdm' => array(
                'name' => 'SyncML - Device Management',
                'type' => 'application/vnd.syncml.dm+wbxml'
            ),
            'xdm' => array(
                'name' => 'SyncML - Device Management',
                'type' => 'application/vnd.syncml.dm+xml'
            ),
            'sv4cpio' => array(
                'name' => 'System V Release 4 CPIO Archive',
                'type' => 'application/x-sv4cpio'
            ),
            'sv4crc' => array(
                'name' => 'System V Release 4 CPIO Checksum Data',
                'type' => 'application/x-sv4crc'
            ),
            'sbml' => array(
                'name' => 'Systems Biology Markup Language',
                'type' => 'application/sbml+xml'
            ),
            'tsv' => array(
                'name' => 'Tab Seperated Values',
                'type' => 'text/tab-separated-values'
            ),
            'tiff' => array(
                'name' => 'Tagged Image File Format',
                'type' => 'image/tiff'
            ),
            'tao' => array(
                'name' => 'Tao Intent',
                'type' => 'application/vnd.tao.intent-module-archive'
            ),
            'tar' => array(
                'name' => 'Tar File (Tape Archive)',
                'type' => 'application/x-tar'
            ),
            'tcl' => array(
                'name' => 'Tcl Script',
                'type' => 'application/x-tcl'
            ),
            'tex' => array(
                'name' => 'TeX',
                'type' => 'application/x-tex'
            ),
            'tfm' => array(
                'name' => 'TeX Font Metric',
                'type' => 'application/x-tex-tfm'
            ),
            'tei' => array(
                'name' => 'Text Encoding and Interchange',
                'type' => 'application/tei+xml'
            ),
            'txt' => array(
                'name' => 'Text File',
                'type' => 'text/plain'
            ),
            'dxp' => array(
                'name' => 'TIBCO Spotfire',
                'type' => 'application/vnd.spotfire.dxp'
            ),
            'sfs' => array(
                'name' => 'TIBCO Spotfire',
                'type' => 'application/vnd.spotfire.sfs'
            ),
            'tsd' => array(
                'name' => 'Time Stamped Data Envelope',
                'type' => 'application/timestamped-data'
            ),
            'tpt' => array(
                'name' => 'TRI Systems Config',
                'type' => 'application/vnd.trid.tpt'
            ),
            'mxs' => array(
                'name' => 'Triscape Map Explorer',
                'type' => 'application/vnd.triscape.mxs'
            ),
            't' => array(
                'name' => 'troff',
                'type' => 'text/troff'
            ),
            'tra' => array(
                'name' => 'True BASIC',
                'type' => 'application/vnd.trueapp'
            ),
            'ttf' => array(
                'name' => 'TrueType Font',
                'type' => 'application/x-font-ttf'
            ),
            'ttl' => array(
                'name' => 'Turtle (Terse RDF Triple Language)',
                'type' => 'text/turtle'
            ),
            'umj' => array(
                'name' => 'UMAJIN',
                'type' => 'application/vnd.umajin'
            ),
            'uoml' => array(
                'name' => 'Unique Object Markup Language',
                'type' => 'application/vnd.uoml+xml'
            ),
            'unityweb' => array(
                'name' => 'Unity 3d',
                'type' => 'application/vnd.unity'
            ),
            'ufd' => array(
                'name' => 'Universal Forms Description Language',
                'type' => 'application/vnd.ufdl'
            ),
            'uri' => array(
                'name' => 'URI Resolution Services',
                'type' => 'text/uri-list'
            ),
            'utz' => array(
                'name' => 'User Interface Quartz - Theme (Symbian)',
                'type' => 'application/vnd.uiq.theme'
            ),
            'ustar' => array(
                'name' => 'Ustar (Uniform Standard Tape Archive)',
                'type' => 'application/x-ustar'
            ),
            'uu' => array(
                'name' => 'UUEncode',
                'type' => 'text/x-uuencode'
            ),
            'vcs' => array(
                'name' => 'vCalendar',
                'type' => 'text/x-vcalendar'
            ),
            'vcf' => array(
                'name' => 'vCard',
                'type' => 'text/x-vcard'
            ),
            'vcd' => array(
                'name' => 'Video CD',
                'type' => 'application/x-cdlink'
            ),
            'vsf' => array(
                'name' => 'Viewport+',
                'type' => 'application/vnd.vsf'
            ),
            'wrl' => array(
                'name' => 'Virtual Reality Modeling Language',
                'type' => 'model/vrml'
            ),
            'vcx' => array(
                'name' => 'VirtualCatalog',
                'type' => 'application/vnd.vcx'
            ),
            'mts' => array(
                'name' => 'Virtue MTS',
                'type' => 'model/vnd.mts'
            ),
            'vtu' => array(
                'name' => 'Virtue VTU',
                'type' => 'model/vnd.vtu'
            ),
            'vis' => array(
                'name' => 'Visionary',
                'type' => 'application/vnd.visionary'
            ),
            'viv' => array(
                'name' => 'Vivo',
                'type' => 'video/vnd.vivo'
            ),
            'ccxml' => array(
                'name' => 'Voice Browser Call Control',
                'type' => '"application/ccxml+xml,"'
            ),
            'vxml' => array(
                'name' => 'VoiceXML',
                'type' => 'application/voicexml+xml'
            ),
            'src' => array(
                'name' => 'WAIS Source',
                'type' => 'application/x-wais-source'
            ),
            'wbxml' => array(
                'name' => 'WAP Binary XML (WBXML)',
                'type' => 'application/vnd.wap.wbxml'
            ),
            'wbmp' => array(
                'name' => 'WAP Bitamp (WBMP)',
                'type' => 'image/vnd.wap.wbmp'
            ),
            'davmount' => array(
                'name' => 'Web Distributed Authoring and Versioning',
                'type' => 'application/davmount+xml'
            ),
            'woff' => array(
                'name' => 'Web Open Font Format',
                'type' => 'application/x-font-woff'
            ),
            'wspolicy' => array(
                'name' => 'Web Services Policy',
                'type' => 'application/wspolicy+xml'
            ),
            'webp' => array(
                'name' => 'WebP Image',
                'type' => 'image/webp'
            ),
            'wtb' => array(
                'name' => 'WebTurbo',
                'type' => 'application/vnd.webturbo'
            ),
            'wgt' => array(
                'name' => 'Widget Packaging and XML Configuration',
                'type' => 'application/widget'
            ),
            'hlp' => array(
                'name' => 'WinHelp',
                'type' => 'application/winhlp'
            ),
            'wml' => array(
                'name' => 'Wireless Markup Language (WML)',
                'type' => 'text/vnd.wap.wml'
            ),
            'wmls' => array(
                'name' => 'Wireless Markup Language Script (WMLScript)',
                'type' => 'text/vnd.wap.wmlscript'
            ),
            'wmlsc' => array(
                'name' => 'WMLScript',
                'type' => 'application/vnd.wap.wmlscriptc'
            ),
            'wpd' => array(
                'name' => 'Wordperfect',
                'type' => 'application/vnd.wordperfect'
            ),
            'stf' => array(
                'name' => 'Worldtalk',
                'type' => 'application/vnd.wt.stf'
            ),
            'wsdl' => array(
                'name' => 'WSDL - Web Services Description Language',
                'type' => 'application/wsdl+xml'
            ),
            'xbm' => array(
                'name' => 'X BitMap',
                'type' => 'image/x-xbitmap'
            ),
            'xpm' => array(
                'name' => 'X PixMap',
                'type' => 'image/x-xpixmap'
            ),
            'xwd' => array(
                'name' => 'X Window Dump',
                'type' => 'image/x-xwindowdump'
            ),
            'der' => array(
                'name' => 'X.509 Certificate',
                'type' => 'application/x-x509-ca-cert'
            ),
            'fig' => array(
                'name' => 'Xfig',
                'type' => 'application/x-xfig'
            ),
            'xhtml' => array(
                'name' => 'XHTML - The Extensible HyperText Markup Language',
                'type' => 'application/xhtml+xml'
            ),
            'xml' => array(
                'name' => 'XML - Extensible Markup Language',
                'type' => 'application/xml'
            ),
            'xdf' => array(
                'name' => 'XML Configuration Access Protocol - XCAP Diff',
                'type' => 'application/xcap-diff+xml'
            ),
            'xenc' => array(
                'name' => 'XML Encryption Syntax and Processing',
                'type' => 'application/xenc+xml'
            ),
            'xer' => array(
                'name' => 'XML Patch Framework',
                'type' => 'application/patch-ops-error+xml'
            ),
            'rl' => array(
                'name' => 'XML Resource Lists',
                'type' => 'application/resource-lists+xml'
            ),
            'rs' => array(
                'name' => 'XML Resource Lists',
                'type' => 'application/rls-services+xml'
            ),
            'rld' => array(
                'name' => 'XML Resource Lists Diff',
                'type' => 'application/resource-lists-diff+xml'
            ),
            'xslt' => array(
                'name' => 'XML Transformations',
                'type' => 'application/xslt+xml'
            ),
            'xop' => array(
                'name' => 'XML-Binary Optimized Packaging',
                'type' => 'application/xop+xml'
            ),
            'xpi' => array(
                'name' => 'XPInstall - Mozilla',
                'type' => 'application/x-xpinstall'
            ),
            'xspf' => array(
                'name' => 'XSPF - XML Shareable Playlist Format',
                'type' => 'application/xspf+xml'
            ),
            'xul' => array(
                'name' => 'XUL - XML User Interface Language',
                'type' => 'application/vnd.mozilla.xul+xml'
            ),
            'xyz' => array(
                'name' => 'XYZ File Format',
                'type' => 'chemical/x-xyz'
            ),
            'yang' => array(
                'name' => 'YANG Data Modeling Language',
                'type' => 'application/yang'
            ),
            'yin' => array(
                'name' => 'YIN (YANG - XML)',
                'type' => 'application/yin+xml'
            ),
            'zir' => array(
                'name' => 'Z.U.L. Geometry',
                'type' => 'application/vnd.zul'
            ),
            'zip' => array(
                'name' => 'Zip Archive',
                'type' => 'application/zip'
            ),
            'zmm' => array(
                'name' => 'ZVUE Media Manager',
                'type' => 'application/vnd.handheld-entertainment+xml'
            ),
            'zaz' => array(
                'name' => 'Zzazz Deck',
                'type' => 'application/vnd.zzazz.deck+xml'
            )
        );

        return $mimeTypes[$fileExtension];
    }
}