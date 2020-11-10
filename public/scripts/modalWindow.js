
class AbstractField {
    constructor() {
        this.content = $("")
        this.parent = null
    }
    append(parent) {
        this.content = this.content.appendTo(parent)
        return this
    }
    set_parent(parent) {
        this.parent = parent
        return this
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
    required(val) {
        this.content.find('input').prop( "required", val )
        return this
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

class MinimoPageSelect extends AbstractField {
    constructor(options) {
        super();
        const _thisRef = this
        this.csrf = ""
        this.route = ""
        this.content = $(
            '<div class="minimo-text-input" style="margin-bottom: -15px;">' +
            '   <input class="minimo-page-select-input" autocomplete = "off" placeholder="Start typing to search..." type="text" name=' + options.name + '>' +
            '</div>' +
            '<div class="pages-select-list">' +
            '</div>'
        )
        this.content.find('.minimo-page-select-input').keyup(function (event) {
            _thisRef.sendRequest($(this).val())
        })
    }

    set_csrf(val) {
        this.csrf = val
        return this
    }

    set_route(val) {
        this.route = val
        return this
    }

    sendRequest(text) {
        const _thisRef = this
        const fd = new FormData();
        fd.append("_token", this.csrf)
        fd.append("title", text)
        $.ajax({
            url: this.route,
            type: "POST",
            data: fd,
            success: function (data) {
                _thisRef.parent.modal.find('.pages-select-list').html("")
                _thisRef.parent.modal.find('input[name="aliasTo"]').val("")
                for (let page in data["pages"]) {
                    const title = data["pages"][page]["title"]
                    const id = data["pages"][page]["id"]
                    const item = $('<div class="pages-list-item" pageid='+ id +'>'+ title +' - '+ id +' </div>')
                        .click(function (){
                            $(this).parent().find(".pages-list-item").removeClass("selected")
                            $(this).addClass("selected")
                            _thisRef.parent.modal.find('input[name="aliasTo"]').val($(this).attr("pageid"))
                        })
                    _thisRef.parent.modal.find('.pages-select-list').append(item)
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

}

class MinimoTextArea extends AbstractField {
    constructor(options) {
        super();
        this.content = $("" +
            "<div class=\"minimo-text-input\" style='margin-bottom: 15px'>\n" +
            "   <textarea name="+ options.name +" type=\"textarea\" rows=\"3\" class=\"pl-caption\"></textarea>\n" +
            "   <span>"+ options.title +"</span>\n" +
            "</div>")
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
        field.append(this.modal.find('.modal-form'))
        field.set_parent(this)
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
        this.modal.find(".error-message").addClass("inactive")
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
