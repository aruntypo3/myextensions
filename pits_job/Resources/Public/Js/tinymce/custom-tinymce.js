tinymce.init({
    mode : "specific_textareas",
    editor_selector : "mceEditor",
    theme: "modern",
    language : 'de',
    menubar: false,
    forced_root_block : false,
    force_br_newlines : true,
    force_p_newlines : false,
    plugins: [
        "autolink link",
    ],
    toolbar: "link",
    target_list: false,
    valid_elements : "a[href|target=_blank],strong/b,div[align],br,span"
   
 });


