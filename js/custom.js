window.addEventListener('DOMContentLoaded', () => {
    console.log('test ')
    $('#toggle-sidebar-md').click(() => {
        console.log('clicked')
        $(document.body).toggleClass('sidebar-close')
    })
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
}, false)