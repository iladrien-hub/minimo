
class AbstractField {
    constructor() {
        this.content = $("")
    }
    getContent() {
        return this.content
    }
}

class MinimoTextInput extends AbstractField {
    constructor(options) {
        super();
        this.content = $('<div class="minimo-text-input">\n' +
            '   <input required type="text" name=' + options.name + '>\n' +
            '   <span>' + options.title + '</span>\n' +
            '</div>')
    }
}

class MinimoSelect extends AbstractField {
    constructor(options) {
        super();
        this.content = $('<select name=' + options.name + ' class="minimo-select" required>\n' +
            '   <option value="" disabled selected>'+ options.title +'</option>\n' +
            '</select>')
    }

    option(key, value) {
        this.content.append('<option value=' + key + '>' + value + '</option>')
        return this
    }
}

class ModalWindow {
    constructor() {
        const _thisRef = this
        this.route = ""
        this.modal = $('<div class="modal inactive">' +
            '   <div class="modal-window">' +
            '       <div class="modal-head">\n' +
            '            <div class="name"></div>\n' +
            '            <i class="modal-close fas fa-times"></i>\n' +
            '       </div>' +
            '       <div class="modal-content">' +
            '           <style> .inactive { display: none; } </style>' +
            '           <i class="fas fa-exclamation error-message inactive" style="color: #ff0000; margin: 5px"></i>' +
            '           <form class="modal-form">' +
            '           </form>' +
            '       </div>' +
            '   </div>' +
            '</div>')
        this.modal.appendTo('body')
        this.modal.find('.modal-close').click(function () {
            _thisRef.remove()
        })
        this.modal.find('.modal-form').submit(function (event) {
            event.preventDefault()
            _thisRef.commit()
        })
    }
    setRoute(route) {
        this.route = route
        return this
    }
    setTitle(title) {
        this.modal.find('.name').html(title)
        return this
    }
    append(what) {
        this.modal.find('.modal-form').append(what)
        return this
    }
    appendField(field) {
        this.modal.find('.modal-form').append(field.getContent())
        return this
    }
    addSubmit() {
        this.modal.find('.modal-form').append('<button type="submit" class="minimo-button">Ok</button>')
        return this
    }
    show() {
        this.modal.find("input").prop( "disabled", false )
        this.modal.removeClass('inactive')
        return this
    }
    remove() {
        this.clear()
        this.modal.addClass('inactive')
        return this
    }
    clear() {
        this.modal.find("input:not([type=hidden])").val("")
    }
    commit() {
        const _thisRef = this
        _thisRef.modal.find(".error-message").addClass("inactive")
        _thisRef.modal.find("input").prop( "disabled", false )
        $.ajax({
            url: this.route,
            type: "POST",
            data: new FormData(this.modal.find('.modal-form')[0]),
            success: function (data) {
                if (data["status"] == false) {
                    _thisRef.modal.find(".error-message").removeClass("inactive").html(" " + data["message"])
                } else {
                    location.reload();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
}
