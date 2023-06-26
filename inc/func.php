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