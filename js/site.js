$(function() {
    
    // Reload page
    $("[type=reset]").click(function (e) {
        e.preventDefault();
        location = location;
    });
   
    // Check all checkboxes
    $("[data-check]").click(function (e) { 
        e.preventDefault();
        var name = $(this).data("check");
        $(`[name="${name}"]`).prop("checked", true).change();
    });
   
    // Uncheck all checkboxes
    $("[data-uncheck]").click(function (e) { 
        e.preventDefault();
        var name = $(this).data("uncheck");
        $(`[name="${name}"]`).prop("checked", false).change();
    });
    
    // Invert checkboxes
    $("[data-invert]").click(function (e) { 
        e.preventDefault();
        var name = $(this).data("invert");
        $(`[name="${name}"]`).each(function () {
            this.checked = !this.checked;           
        }).change();
    });
   
    // Auto uppercase
    $("[data-upper]").on("input", function (e) {
        var a = this.selectionStart;
        var b = this.selectionEnd;
        this.value = this.value.toUpperCase();        
        this.setSelectionRange(a, b);
    });
    
    // Load a page using GET request
    $("[data-get]").click(function (e) {
        e.preventDefault();
        var url = $(this).data("get");
        location = url;
    });
    
    // Submit the closest form
    $("[data-submit]").click(function (e) {
       e.preventDefault();
       $(this).closest("form").submit();
    });
    
});
