	<div class="main">
		<p><h1>Text Editor</h1>
		<p>To generate HTML code, please edit your text in the text editor below and then click "Show Source" button at the bottom left corner.
		<p><textarea name="content" id="textarea" width="800" height="600"></textarea>
	</div>

<script>
	new TINY.editor.edit('editor',{
		id:'textarea',
		width:800,
		height:600,
		cssclass:'te',
		controlclass:'tecontrol',
		rowclass:'teheader',
		dividerclass:'tedivider',
		controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
				  'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
				  'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n', '|',
				  'style', 'image', 'link','unlink','|','cut','copy','paste'],
		footer:true,
		fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
		xhtml:true,
		cssfile:'./css/style_editor.css',
		bodyid:'editor',
		footerclass:'tefooter',
		toggle:{text:'show source',activetext:'show wysiwyg',cssclass:'toggle'},
		resize:{cssclass:'resize'}
	});
</script>