@extends('main')

@section('content')
    <div class="modal-picture-loader modal inactive">
        <div class="modal-window">
            <div class="modal-head">
                <div class="name">Picture</div>
                <i class="modal-close fas fa-times"></i>
            </div>
            <div class="modal-content">
                <div class="picture-choise">
                    <div class="picture-loader">
                        @foreach ($pictures as $pic)
                            <div class="picture-loader-item">
                                <img src="{{ asset('public/images/'.$pic->filename) }}" alt="{{ $pic->filename }}">
                            </div>
                        @endforeach
                        <div class="picture-addnew">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div>
                    <form action="">
                        @csrf
                        <input required type="file" name="image" class="picture-loader-image" hidden="hidden" accept="image/*">
                    </form>
                    <div class="picture-loader-form hidden-form">
                        <div class="picture-loader-result"></div>
                        <div class="minimo-text-input" style="display: none;">
                            <input required type="text" class="pl-title" >
                            <span>Title</span>
                        </div>
                        <div class="minimo-text-input">
                            <input required type="text" class="pl-alt">
                            <span>Alt</span>
                        </div>
                        <div class="minimo-text-input">
                            <textarea required type="textarea" rows="3" class="pl-caption"></textarea>
                            <span>Caption</span>
                        </div>
                        <div class="minimo-text-input" style="display: none;">
                            <textarea required type="textarea" rows="3" class="pl-descr"></textarea>
                            <span>Description</span>
                        </div>
                        <button class="minimo-button picture-loader-commit">
                            Ok
                        </button>
                    </div>
                    <script>
                        var resultSrc = "";
                        var resultHtml = "";
                        function updateResult() {
                            title   = $(".pl-title").val()
                            alt     = $(".pl-alt").val()
                            caption = $(".pl-caption").val()
                            descr   = $(".pl-descr").val()
                            if (caption != "") {
                                caption = "<div class='minimo-image-caption'>“" + caption + "”</div>";
                            }
                            resultHtml = `<div class="minimo-image"><img src="${resultSrc}" alt="${alt}">${caption}</div>`;
                            $(".picture-loader-result").text(resultHtml);
                        }
                        function getPLResult() {
                            res = resultHtml;
                            resultHtml = "";
                            return res;
                        }
                        $(".picture-addnew").click(function(){ $(".picture-loader-image").click(); });
                        function pictureLoadItemClicked() {
                            if ($(this).hasClass("chosen-item")){
                                $(this).removeClass("chosen-item");
                                form = $(this).parent().parent().parent().find(".picture-loader-form");
                                form.addClass("hidden-form");
                            } else {
                                parent = $(this).parent();
                                parent.find(".picture-loader-item").removeClass("chosen-item");
                                parent.parent().parent().find(".picture-loader-form").removeClass("hidden-form");
                                $(this).addClass("chosen-item");
                                resultSrc = $(this).find("img").attr("src");
                                updateResult();
                            }
                        }
                        $(".picture-loader-item").click(pictureLoadItemClicked);
                        $(".picture-loader-form").find("input").keyup(function(){ updateResult() });
                        $(".picture-loader-form").find("textarea").keyup(function(){ updateResult() });
                        $(".picture-loader-image").change(function() {
                            if ($(this).val() != "") {
                                pl = $(this).parent().parent().parent().find(".picture-loader")
                                $.ajax({
                                    url: "{{ route('upload-image') }}",
                                    type: "POST",
                                    data: new FormData($(this).parent()[0]),
                                    success: function (data) {
                                        path = "{{ asset('public/images/') }}/"
                                        newitem = `<div class="picture-loader-item"><img src="${path + data["filename"]}" alt="${data["filename"]}"></div>`
                                        pl.prepend(newitem);
                                        pl.find(".picture-loader-item:first-child").click(pictureLoadItemClicked);
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                            }
                        })
                    </script>
                </div>
            </div>
        </div>
        <script>
            $(".modal-close").click(function(){
                $(this).parent().parent().parent().addClass('inactive');
            })
        </script>
    </div>








    <div class="container">
        <form action="{{route('create-post')}}" method="post" class="creator" enctype="multipart/form-data">
            @csrf
            <h1>A new post</h1>
            <input type="hidden" name="parent" value="{{ $parent }}">
            <div class="meta-field">
                <div class="row">
                    <div class="minimo-text-input">
                        <input required type="text" name="id">
                        <span>id</span>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-text-input">
                        <input required type="text" name="title">
                        <span>Title</span>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-text-input">
                        <textarea required type="textarea" rows="3" name="short"></textarea>
                        <span>Short</span>
                    </div>
                </div>
                <div class="row">
                    <div class="minimo-file-input">
                        <input required type="file" class="creator-meta-image" name="post-picture" hidden="hidden" accept="image/*">
                        <button type="button" class="minimo-button" default="Choose preview picture">Choose preview picture</button>
                    </div>
                </div>
            </div>
            <div class="creator-toolbar">
                <div class="creator-tools">
                    <ul>
                        <li><button type="button" onclick="executeCommand('bold');"><i class="fas fa-bold"></i></button></li>
                        <li><button type="button" onclick="executeCommand('italic');"><i class="fas fa-italic"></i></button></li>
                        <li><button type="button" onclick="executeCommand('underline');"><i class="fas fa-underline"></i></button></li>
                        <li><div class="separator"></div></li>
                        <li><button type="button" onclick="executeCommand('JustifyLeft');"><i class="fas fa-align-left"></i></button></li>
                        <li><button type="button" onclick="executeCommand('JustifyCenter');"><i class="fas fa-align-center"></i></button></li>
                        <li><button type="button" onclick="executeCommand('justifyFull');"><i class="fas fa-align-justify"></i></button></li>
                        <li><button type="button" onclick="executeCommand('JustifyRight');"><i  class="fas fa-align-right"></i></button></li>
                        <li><div class="separator"></div></li>
                        <li><button type="button" onclick="addImage();"><i class="fas fa-image"></i></i></button></li>
                    </ul>
                </div>
                <input type="text" class="creator-field-input" name="content" hidden="true">   
                <iframe class="creator-field" id="newTextArea" name="newTextArea" src="{{ asset('public/html') }}/creator-field.html"></iframe>
            </div>
            <div class="creator-commit">
                <button type="submit" class="minimo-button">
                    Ok 
                </button>
            </div>
        </form>
    </div>
    <script>
        window.onload = () => {
            newTextArea.document.designMode = "on";
        };
        function executeCommand(cmd) {
            newTextArea.document.execCommand(cmd, false, null);
        }
        function commandWithArg(cmd,arg) {
            newTextArea.document.execCommand(cmd, false, arg);
        }
        function addImage() {
            $('.modal-picture-loader').removeClass("inactive");
        }
        $(".creator").submit(function(){
            $(".creator-field-input").val(newTextArea.document.body.innerHTML); 
        })
        $(".picture-loader-commit").click(function() {
            loader = $(".picture-choise")
            loader.find("input[type='text'], textarea").val("");
            loader.find(".picture-loader-form").addClass("hidden-form")
            loader.find(".chosen-item").removeClass("chosen-item")
            $('.modal-picture-loader').addClass("inactive");
            newTextArea.document.execCommand("insertHTML", false, getPLResult() + "<br/>");
            newTextArea.focus();
            var len = newTextArea.document
            console.log(len)
        })
    </script>
    <script>
        // Minimo file input
        $(".minimo-file-input").find("button").click(function() {
            $(this).parent().find("input").click();
        })
        $(".minimo-file-input").find("input").change(function() {
            button = $(this).parent().find("button")
            if ($(this).val() != '') button.html($(this)[0].files[0].name);
            else button.html(button.attr('default'));
        })
    </script>
@endsection