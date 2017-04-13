AP.require(["jira"], function(jira) {
  jira.WorkflowConfiguration.onSave(function() {
    console.log(arguments);
    return "string for JIRA to store";
  });
  jira.WorkflowConfiguration.onSaveValidation(function() {
    return true;
  });
});

$(document).ready(function () {
    var codeDefaults = {
        mode: "javascript",
        theme: "neat",
        lineNumbers:true,
        gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
        indentWithTabs:false,
        electricChars:true,
        indentUnit:2,
        lineWrapping: true,
        readOnly:true
    };

    $('pre code').each(function(){
        codify(this)
    });

    function codify(block) {
        var text = $(block).text().trim(),
            newOpts = $.extend({}, codeDefaults);

        if (text.split("\n").length <= 1) {
            newOpts.lineNumbers = false;
            newOpts.gutters = [];
        }
        newOpts.value = text;

        var cm = CodeMirror(
            function(node){
                block.parentNode.replaceChild(node, block)
            }, newOpts
        );
    }
});