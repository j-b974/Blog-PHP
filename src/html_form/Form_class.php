<?php

namespace app\html_form;

class Form_class
{
    /**
     * @var data instence de class post
     */
    private $data;

    private $error;

    public function __construct($dt , array $error)
    {
        $this->data = $dt;
        $this->error = $error;
    }
    public function select_Cat(string $key , string $label, array $option )
    {

        $nb_cat = count($option);
        $opt =[];
        foreach ($option as $k => $v) 
        {
            $select = null;

            if(in_array($k,$this->data->get_list_id_cat())){$select = ' selected';}

            $opt[]= "<option value ='$k' $select >$v</option>";
        }
        $opt_str = implode('',$opt);
        return <<<HTML
        <div class="form-group">
            <label class="font-weight-bold">$label</label> 
            <select class="form-control {$this->get_invalid($key)}" name ="{$key}[]" multiple size='{$nb_cat}'>
                {$opt_str}
            </select>
            {$this->get_feedback($key)}
        </div>
HTML;
    }
    public function get_input(string $key , string $label)
    {
        $type = $key ==='password' ? 'password' : 'text';
        return <<<HTML
            <div class="form-group">
                <label class="font-weight-bold" for="{$key}">{$label}</label>
                <input class="form-control {$this->get_invalid($key)}" type="{$type}" name="{$key}" id="{$key}" value = "{$this->get_methode($key)}">
                {$this->get_feedback($key)}
            </div>
HTML;
    }
    public function get_textarea($key,string $label) : ?string
    {
        return <<<HTML
        <div class="form-group">
            <label class="font-weight-bold" for="{$key}">{$label}</label>
            <textarea class="form-control {$this->get_invalid($key)}" type="text" name="{$key}" rows="15" id="{$key}">{$this->get_methode($key)}</textarea>
            {$this->get_feedback($key)}
        </div>
HTML;
        
    }
    private function get_methode($key)
    {
        $met = 'get_'.$key;

        $methode = $this->data->$met();
        if($methode instanceof \DateTimeInterface)
        {
            return $methode->format('Y-m-d h:i:s');
        }
        return $methode;
    }

    private function get_invalid(string $key) : ?string
    {
       return (!isset($this->error[$key])) ? '': 'is-invalid';
    }
    private function get_feedback(string $key) : ?string
    {

            if(key_exists($key,$this->error))
            {
                $e = implode('<br/>',$this->error[$key]);
                return <<<HTML
                <div class="invalid-feedback text-warning">$e</div>
HTML;
            }
            return '';
    }
}