CKEDITOR.editorConfig = function( config ) {
	config.removePlugins = 'easyimage,cloudservices,FontName';
	config.toolbarGroups = [
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'styles'  },
		'/',
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	config.extraPlugins = 'lineheight';
	//config.line_height="1px;2px;3px;4px;5px;6px;7px;8px;9px;10px;11px;12px;13px;14px;15px;16px;17px;18px;19px;20px;21px;22px;23px;24px;25px;26px;27px;28px;29px;30px;" ;
	config.enterMode = CKEDITOR.ENTER_BR;
config.startupOutlineBlocks = true;
	config.removeButtons = 'FontName,FontFamily,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Image,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,CopyFormatting,RemoveFormat,Language,BGColor,Replace,Find,Save,Print,NewPage,PasteText,Paste,Copy,Cut,PasteFromWord,SelectAll,Scayt,Link,Unlink,Anchor,About,BidiLtr,BidiRtl,Form';
 
 
        config.contentsCss = 'assets/ckeditor/fonts.css';
       config.font_names =  '';
	   config.fontSize_sizes = '6/6px;7/7px;8/8px;9/9px;10/10px;11/11px;12/12px;13/13px;14/14px;15/15px;16/16px;17/17px;18/18px;19/19px;20/20px;21/21px;22/22px;23/23px;24/24px;25/25px;26/26px;27/27px;28/28px;29/29px;30/30px;31/31px;32/32px;33/33px;34/34px;35/35px;36/36px;37/37px;38/38px;39/39px;40/40px;';
	   
		 config.stylesSet = [  
		// { name : 'Normal', element : 'span', attributes : { 'class' : 'normal_face' } },
		 { name : 'Monotype Corsiva', element : 'span', attributes : { 'class' : 'monotype' } },
		 ];
     

};