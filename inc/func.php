<?php
    function input_group($type,$id,$icon,$placeholder,$value='',$tooltip=false)
    {
        if($type=='sel')
        {
            $tool='';
            if($tooltip)
                $tool='data-toggle="tooltip" data-placement="top" title="'.$placeholder.'"';
            
            echo'<div class="input-group"> <div class="input-group-addon"><i class="'.$icon.'"></i></div>
            <select class="form-control" name="'.$id.'" id="'.$id.'" '.$tool.'>';
            echo'<option disabled selected value="-1">...</option>';
            foreach($value as $k => $v)
            {
                echo'<option value="'.$k.'">'.$v.'</option>';
            }
            echo'</select>';
            echo'</div>';
        }
        else
        {
            echo'<div class="input-group"> <div class="input-group-addon"><i class="'.$icon.'"></i></div>
            <input type="text" class="form-control" name="'.$id.'" id="'.$id.'" placeholder="'.$placeholder.'" value="'.$value.'"';
            if($tooltip)
                echo 'data-toggle="tooltip" data-placement="top" title="'.$placeholder.'"';
            echo'></div>';
        }
    }

    function frmControl($id,$placeholder='',$value='',$disabled=''){
        global $campos;
        $control='';
        $type=isset($campos[$id]['type']) ? $campos[$id]['type'] : 'text';
        //$placeholder='';
        $tooltip='';
        if($placeholder=='placeholder'){
            $placeholder=isset($campos[$id]['placeholder']) ? $campos[$id]['placeholder'] : $campos[$id]['detalle'];
        } else if($placeholder=='tooltip'){
            $title=isset($campos[$id]['placeholder']) ? $campos[$id]['placeholder'] : $campos[$id]['detalle'];
            $tooltip='data-toggle="tooltip" data-placement="top" title="'.$title.'"';
            $placeholder='';
        }
        //create a select
        if(isset($campos[$id]['values'])){

            $input='<select '.$disabled.' class="form-control" name="C_'.$id.'" id="C_'.$id.'" '.$tooltip.'>';
            $t=empty($placeholder) ? '...' : $placeholder;
            $input.='<option disabled selected value="">'.$t.'</option>';
            foreach($campos[$id]['values'] as $k => $v){
                $selected=($value==$k) ? 'selected' : '';
                $input.='<option '.$selected.' value="'.$k.'">'.$v.'</option>';
            }
            $input.='</select>';
        } else {
            $input='<input '.$disabled.' type="'.$type.'" class="form-control" name="C_'.$id.'" id="C_'.$id.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$tooltip.'>';
        }
        return $input;
    }