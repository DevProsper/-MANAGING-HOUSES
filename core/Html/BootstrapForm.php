<?php
/**
 * Created by PhpStorm.
 * Users: DevProsper
 * Date: 14/03/2018
 * Time: 22:55
 */

namespace Core\Html;


class BootstrapForm extends Form
{

    public $errors = [];
    public $data;

    protected function surround($html){
        return "<div class=\"form-group\">{$html}</div>";
    }

    public function input($name,$label = null,$options = []){
        $label = '<label>'.$label.'</label>';
        $type = isset($options['type']) ? $options['type'] : 'text';
        if($type === 'textarea'){
            $input = '<textarea name="'.$name.'" class="form-control">' .$this->getValue($name).'</textarea>';
        }else{
            $input = '<input type="'.$type.'" name="'.$name.'" value="'.$this->getValue($name).'" class="form-control">';
        }
        if (isset($errors[$name])) {
            ?>
            <p class="help-block"><?= $errors[$name]; ?></p>
            <?php
        }
        return $this->surround($label . $input);
    }

    public function input2($name,$options = []){
        $html =  ' ';
        $attr = ' ';
        $value = isset($_POST[$name]) ? $_POST[$name] : '';
        foreach ($options as $k => $v) {if($k != 'type'){
            $attr .= " $k=\"$v\"";
        }}
        if(!isset($options['type'])) {
            $html .= '<input type="text" value="'.$value.'"
		id="'.$name.'" name="'.$name.'"'.$attr.'>';
        }elseif ($options['type'] == 'textarea') {
            $html .= '<textarea  id="'.$name.'" name="'.$name.'"'.$attr.'>'.$value.'</textarea>';
        }elseif ($options['type'] == 'email') {
            $html .= '<input type="email" value="'.$value.'"
		id="'.$name.'" name="'.$name.'"'.$attr.'>';
        }elseif ($options['type'] == 'password') {
            $html .= '<input type="password"
		id="'.$name.'" name="'.$name.'"'.$attr.'>';
        }elseif ($options['type'] == 'checkbox') {
            $html .= '<input  type="hidden" name="'.$name.'" '.$attr.' value="0">
		<input  type="checkbox" name="'.$name.'"'.$attr.' value="1" '.(empty($value)?'' : 'checked').'>';
        }elseif ($options['type'] == 'select') {
            $html .= "<select id='$name' name='$name'>";
            foreach ($options as $k => $v) {
                $selected = '';
                if (isset($_POST[$name]) && $k == $_POST[$name]) {
                    $selected = 'selected="selected"';
                }
                $html .= "<option value='$k' $selected>$v</option>";
            }
            $html .= "</select>";
        }elseif ($options['type'] == 'radio') {
            $html .= '<input type="radio" name="'.$name.'" id="'.$name.'" value="1" '.(empty($value)?'' : 'checked').'>
		<input type="radio" name="'.$name.'" id="'.$name.'" value="1" '.(empty($value)?'' : 'checked').'>';
        }
        return $html;
    }

    public function submit(){
        return $this->surround('<button type="submit" class="btn btn-primary">Envoyer</button>');
    }

    public function select($name, $label, $options)
    {
        $label = '<label>'.$label.'</label>';
        $input = '<select class="form-control" name="'.$name.'">';
        if(empty($name)){
            $input .= "<option value=''>-- Selectionner ---</option>";
        }
        foreach($options as $k => $v){
        $attributes = '';
        if ($k == $this->getValue($name)) {
        	$attributes = ' selected';
        }
            $input .= "<option value='$k'$attributes>$v</option>";
        }
        $input .= '</select>';

        return $this->surround($label . $input);
    }
}