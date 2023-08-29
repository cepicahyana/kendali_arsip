<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form  
{
	
	 
/* =============================== FORM INPUT TEXT ==================================================*/
	public function input($data )
	{
		$focus = isset($data["focus"])?($data["focus"]):null;
		$name = isset($data["name"])?($data["name"]):null;
		$label = isset($data["label"])?($data["label"]):null;
		$title = isset($data["title"])?($data["title"]):null;
		$value = isset($data["value"])?($data["value"]):null;
		 if($focus)
		 {
			$focus="focused"; 
		 }

		 if(!$label){
			$label = $title;
		 }
		return '<div class="row row-xs align-items-center mg-b-20">
		<div class="col-md-4">
			<label class="form-label mg-b-0 text-black">'.$label.' </label>
		</div>
		<div class="col-md-8 mg-t-5 mg-md-t-0">
			<input class="form-control text-black"   name="'.$name.'"  placeholder="'.$title.'..." type="text" value="'.$value.'">
		</div>
	</div>';
	}
	public function input1($field=null,$title=null,$help=null,$atr=null,$focus=null)
	{
		 if($focus)
		 {
			$focus="focused"; 
		 }
		return '<div class="input-group">
				<span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                            </span>
                                            <div class="form-line">
                                                <input class="form-control date" placeholder="Ex: 30/07/2016" type="text">
                                            </div>
                 </div>';
	}
	public function input2($field=null,$title=null,$help=null,$atr=null,$focus=null)
	{
		 if($focus)
		 {
			$focus="focused"; 
		 }
		return '    <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email_address_2">'.$title.'</label>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                              <input name="'.$field.'" class="form-control" type="text" '.$atr.'>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
	}
	/*===========================================================*/
	public function cekbox($field=null,$title=null,$value=null,$atr=null)
	{
		
		return '     <div class="demo-checkbox">
									 <input type="checkbox" value="'.$value.'" id="'.$field.'" name="'.$field.'" class="filled-in filled-in chk-col-light-blue"  '.$atr.' />
									 <label for="'.$field.'"><b>'.$title.'</b></label>
									 </div>';
	}
	/* =============================== FORM INPUT TEXTAREA ==================================================*/
	public function textarea($field=null,$title=null,$help=null,$atr=null,$focus=null)
	{
		 if($focus)
		 {
			$focus="focused"; 
		 }
		return '<div class="form-group form-float col-md-12">
                                    <div class="form-line '.$focus.'">
                                       <textarea class="form-control" name="'.$field.'" '.$atr.' ></textarea>  
                                        <label class="form-label col-blue-grey"  >'.$title.'</label>
                                    </div>
									<div class="help-info"><i>'.$help.'</i></div>
                                </div>';
	}
}

?>