<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'forms';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title',
                  'sata'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function getFormKeys() {

        if (!isset ($this->sata)) return array();
        $array = json_decode($this->sata,TRUE);
        return self::NodesToArrayKeys($array);

    }

    /**
     * set of nodes making up the form
     * @param $nodes
     * @return array
     */
    private function NodesToArrayKeys($nodes)
    {
        $retval = array();

        // dump($nodes);
        // die;

        foreach ($nodes as $node)
        {

            if (array_key_exists('type',$node))
            {
                switch($node['type'])
                {
                    case "fieldset":
                    case "form_fieldset":
                    case 'button':
                    case 'form_button':
                    case 'fileupload':
                    case 'form_fileupload':
                    case 'separator':
                    case 'form_separator':
                    case 'image':
                    case 'form_image':
                        //IGNORE
                        break;

                    case 'checkbox':
                    case 'form_checkbox':
                    case 'textarea':
                    case 'form_textarea':
                    case 'text':
                    case 'form_text':
                    case 'paragraph':
                    case 'form_paragraph':
                        //Take value
                        if (array_key_exists('name',$node)){
                            $retval[$node['name']] = (array_key_exists('label', $node)? $node['label'] : '');
                        }

                        break;
                    case 'select':
                    case 'form_select':
                        if (array_key_exists('name',$node)){
                            $retval[$node['name']] = (array_key_exists('label', $node)? $node['label'] : '');
                        }
                    case 'radio':
                    case 'form_radio':
                    case 'multiple-choice':
                    case 'form_multiplechoice':
                        //take selected option
                        if (array_key_exists('name',$node)){
                            $retval[$node['name']] = (array_key_exists('label', $node)? $node['label'] : '');
                        }

                }
                if (array_key_exists('children',$node))
                {
                    $retval1 = self::NodesToArrayKeys($node['children']);
                    foreach($retval1 as $key =>$value)
                    {
                        $retval[$key] = $value;
                    }
                }
            }
        }

        return $retval;

    }

    public function getFormHTML() {
        if (!isset ($this->sata)) return "";
        $array = json_decode($this->sata,TRUE);
        return self::NodesToHTML($array);

    }

    /**
     * set of nodes making up the form
     * @param $nodes
     * @return string
     */
    private function NodesToHTML($nodes)
    {
        $html = "";

        foreach ($nodes as $node)
        {
            $closingtag="";

            if (array_key_exists('type',$node))
            {
                switch($node['type'])
                {
                    case "fieldset":
                    case "form_fieldset":
                        $html .= "<fieldset id=\"".(array_key_exists('name',$node)?$node['name']:"")."\" >";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= "<legend>" . $node['label'] . "</legend>";
                        }
                        $closingtag = "</fieldset>";
                        break;

                    case 'checkbox':
                    case 'form_checkbox':
                        $html.="<div class=\"form-group \">";
                        $html.= "<input id=\"".(array_key_exists('name',$node)?$node['name']:"")."\" name=\"".(array_key_exists('name',$node)?$node['name']:"")."\" type=\"checkbox\"".(array_key_exists('predefinedValue',$node)?" value=\"".$node['predefinedValue']."\"":"").">";

                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'textarea':
                    case 'form_textarea':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= "<textarea id=\"".(array_key_exists('name',$node)?$node['name']:"")."\" class=\"form-control\" name=\"".(array_key_exists('name',$node)?$node['name']:"")."\">".(array_key_exists('predefinedValue',$node)?$node['predefinedValue']:"")."</textarea>";
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'text':
                    case 'form_text':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= "<input id=\"".(array_key_exists('name',$node)?$node['name']:"")."\" class=\"form-control\"  name=\"".(array_key_exists('name',$node)?$node['name']:"")."\" type=\"text\"".(array_key_exists('predefinedValue',$node)?" value=\"".$node['predefinedValue']."\"":""). (array_key_exists('required',$node)?"data-required='true'":"") .">";
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'button':
                    case 'form_button':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= "<button id=\"".(array_key_exists('name',$node)?$node['name']:"")."\" class=\"btn btn-default btn-outline btn-sm\" type=\"".(array_key_exists('buttonType',$node)?$node['buttonType']:"")."\" name=\"".(array_key_exists('name',$node)?$node['name']:"")."\">".(array_key_exists('predefinedValue',$node)?$node['predefinedValue']:"")."</button>";
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'fileupload':
                    case 'form_fileupload':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= "<input id=\"".(array_key_exists('name',$node)?$node['name']:"")."\" name=\"".(array_key_exists('name',$node)?$node['name']:"")."\" type=\"file\"".(array_key_exists('predefinedValue',$node)?" value=\"".$node['predefinedValue']."\"":"").">";
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'select':
                    case 'form_select':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= "<select id=\"".(array_key_exists('name',$node)?$node['name']:"")."\" class=\"form-control\" name=\"".(array_key_exists('name',$node)?$node['name']:"")."\">";

                        if (array_key_exists('options',$node))
                        {
                            foreach ($node['options']  as $subnode)
                            {
                                $html.= "<option value=\"".(array_key_exists('value',$subnode)?$subnode['value']:"")."\" id=\"\">".(array_key_exists('label',$subnode)?$subnode['label']:"")."</option>";
                            }
                        }
                        $html.= " </select>";
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'radio':
                    case 'form_radio':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        if (array_key_exists('options',$node))
                        {
                            $cnt =1;
                            foreach ($node['options']  as $subnode)
                            {
                                $html.= "<input id=\"".(array_key_exists('name',$node)?$node['name']:"").$cnt++."\" name=\"".(array_key_exists('name',$node)?$node['name']:"")."\" type=\"radio\" value=\"".(array_key_exists('value',$subnode)?$subnode['value']:"")."\"> ".(array_key_exists('label',$subnode)?$subnode['label']:"")."<br/>";
                            }
                        }
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'multiple-choice':
                    case 'form_multiplechoice':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        if (array_key_exists('options',$node))
                        {
                            $cnt =1;
                            foreach ($node['options']  as $subnode)
                            {
                                $html.= "<input id=\"".(array_key_exists('name',$node)?$node['name']:"").$cnt++."\" name=\"".(array_key_exists('name',$node)?$node['name'].'[]':"")."\" type=\"checkbox\" value=\"".(array_key_exists('value',$subnode)?$subnode['value']:"")."\"> ".(array_key_exists('label',$subnode)?$subnode['label']:"")."<br/>";
                            }
                        }
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'paragraph':
                    case 'form_paragraph':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= "<p id=\"".(array_key_exists('name',$node)?$node['name']:"")."\"  name=\"".(array_key_exists('name',$node)?$node['name']:"")."\">".(array_key_exists('label',$node)?$node['label']:"")."</p>";
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'separator':
                    case 'form_separator':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= "<div id=\"".(array_key_exists('name',$node)?$node['name']:"")."\"  name=\"".(array_key_exists('name',$node)?$node['name']:"")."\" class=\"separator\" >"."</div>";
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    case 'image':
                    case 'form_image':
                        $html.="<div class=\"form-group \">";
                        if (array_key_exists('showLabel',$node) && $node['showLabel'] ) {
                            if (array_key_exists('label', $node)) $html .= " <label".(array_key_exists('name',$node)?" for=\"".$node['name']."\"":"").">" . $node['label'] . "</label><br/>";
                        }
                        $html.= "<img id=\"".(array_key_exists('name',$node)?$node['name']:"")."\"  name=\"".(array_key_exists('name',$node)?$node['name']:"")."\" src==\"".(array_key_exists('predefinedValue',$node)?" value=\"".$node['predefinedValue']."\"":"")."\" />";
                        $html.= " </div>";
                        $closingtag = "";
                        break;
                    default:

                        break;
                }
                if (array_key_exists('children',$node))
                {
                    $html .= self::NodesToHTML($node['children']);
                }
                $html .= $closingtag;
            }
        }
        return $html;

    }


}
