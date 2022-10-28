
    <script>
        $(".posts-list .pagination a").on('click', function() {
            sessionStorage.setItem('scrollIndex', 'groups_start');
        });
        $(".header__form .group").on('submit', function() {
            sessionStorage.setItem('scrollIndex', 'groups_start');
        });

        $(document).ready(function() {
            if (sessionStorage.getItem('scrollIndex') == 'groups_start') {
                $('html, body').animate({
                    scrollTop: $(".posts-list__filter").offset().top - 20
                });
            }
            sessionStorage.setItem('scrollIndex', '0');

            if ($(window).width() < 520) {
                var prevTitleOver = null,
                    prevTitle = null,
                    prevPostData = null,
                    prevHasGain = null;

                $.each($('.post'), function() {
                    var title = $(this).find(".post__title"),
                        titleHeight = title.height(),
                        postData = $(this).find(".post__data"),
                        hasGain = postData.find("p").length < 4 ? false : true;

                    if (prevTitleOver !== null) {
                        if (prevTitleOver || titleHeight > 30) {
                            title.css('height', '46px');
                            prevTitle.css('height', '46px');
                            title.closest(".post").css('height', '378px');
                            prevTitle.closest(".post").css('height', '378px');
                        }

                        if (!hasGain && !prevHasGain) {
                            postData.css('height', 'auto');
                            prevPostData.css('height', 'auto');

                            var prevPost = prevPostData.closest('.post');

                            $(this).css('height', ($(this).height() - 25) + 'px');
                            prevPost.css('height', (prevPost.height() - 25) + 'px')
                        }

                        prevTitleOver = null;
                        prevHasGain = null;
                    } else {
                        if (titleHeight < 30) {
                            prevTitleOver = false;
                        } else {
                            prevTitleOver = true;
                        }

                        prevHasGain = hasGain;
                        prevPostData = postData;
                        prevTitle = title;
                    }
                });
            }
        });

        var scrollHeightSaved = false;

        $(".posts .post__title a, .post .post__image .post__more a").on('click', function(e) {
            if (!scrollHeightSaved) {
                e.preventDefault();

                sessionStorage.setItem('scrollHeight', $('html').scrollTop());
                scrollHeightSaved = true;
                $(this)[0].click();
            } else {
                scrollHeightSaved = false;
            }
        });

        var backToTop = $("#back-to-top");

        $(document).scroll(function() {
            var header = $('.scroll_down:visible');

            if (header.length) {
                if (isScrolledIntoView(header)) {
                    backToTop.hide();
                    return true;
                }
            }

            backToTop.show();
        });

        backToTop.on('click', function() {
            $('html, body').animate({
                scrollTop: $("body").offset().top
            }, 300);
        });

        function isScrolledIntoView(elem) {
            var docViewTop = $(window).scrollTop();
            var docViewBottom = docViewTop + $(window).height();

            var elemTop = $(elem).offset().top;
            var elemBottom = elemTop + $(elem).height();

            return ((elemBottom - $(elem).height() <= docViewBottom) && (elemTop + $(elem).height() >= docViewTop));
        }

        $(document).ready(function() {
            var allimages = $('.posts.group:last .post__image > img:not(.check-mark):not(.pass-verified)');

            for (var i = 0; i < allimages.length; i++) {
                if (allimages[i].getAttribute('data-src')) {
                    allimages[i].setAttribute('src', allimages[i].getAttribute('data-src'));
                    allimages[i].removeAttribute('style');
                }
            }
        });
    </script>
    <script>
        $(".confirm-submit__submit").on('click', function() {
            var id = $(this).attr('data-id');

            $.ajax({
                url: '/email/send/code',
                method: 'POST',
                data: {
                    id: id,
                    _token: csrf
                }
            }).done(function(data) {
                setNoty(data[1], data[0]);
            });
        });
    </script>

    <script>
        $('.buy-this-group-btn').on('click', function(e) {
            e.preventDefault();

            $("#modal3 form").attr('data-id', $(this).attr('data-id'));
            $("#modal3 form button[type='submit']").attr('data-user-id', $(this).attr('data-user-id'));


            $("#modal3").modal('show');
            return false;
        });

        $("#choose-payment-methods-boxes li").on('click', function() {
            var btn = $(this),
                active = btn.hasClass('active') ? 0 : 1;

            if (!active) {
                btn.removeClass('active');
            } else {
                btn.addClass('active');
            }

            $.ajax({
                url: '/update/user_payment_method',
                method: 'POST',
                data: {
                    active: active,
                    method_id: btn.attr('data-id'),
                    _token: csrf
                }
            })
        });

        $("#modal3 .modal-checkbox label").on('click', function() {
            $('#modal3 #use-garant-or-not').toggle();
        });

        $("#modal3 select[name='transfer']").on('change', function() {
            var id = $(this).val();

            $("#modal3 .transfer-text").hide();
            $("#modal3 .transfer-phone.group").hide();
            $("#modal3 .transfer-text[data-type='" + id + "']").show();

            if (id > 0) {
                $("#modal3 .transfer-phone.group[data-type='1']").show();
            } else {
                $("#modal3 .transfer-phone.group[data-type='0']").show();
            }
        });

        function sendMessage(to, message) {
            return $.ajax({
                    url: "/chat/send",
                    data: {
                        msg: message,
                        to: to,
                        _token: csrf
                    },
                    method: 'POST'
                })
                .done(function(data) {
                    typing = false;

                    if (!data.msg_id) {
                        if (data[0] == 'error') {
                            setNoty(data[1], 'error');
                        } else {
                            setNoty('Your account is blocked.', 'error');
                        }
                    }
                });
        }

        function createGarant(groupId, message, transfer, info, button, paymentIds, preloader, button) {
            $.ajax({
                    url: "/garant/create",
                    data: {
                        group_id: groupId,
                        message: message,
                        transfer: transfer,
                        info: info,
                        payment_ids: paymentIds,
                        _token: csrf
                    },
                    method: 'POST'
                })
                .done(function(data) {
                    if (data[0] == 'error') {
                        preloader.hide();
                        button.show();
                        setNoty(data[1], 'error');
                    } else {
                        $(".deal-request-preloader").hide();
                        button.show();
                        $("#modal3").modal('hide');

                        $.when(loadDialogs('start')).then(function() {
                            return createDialogChat(button, data.msg_register);
                        }).done(function() {
                            if ($(".garant-container[data-id='" + data.garant_id + "']").length) return false;

                            var list = $(".chat__messages[data-id='" + data.msg_to + "'] .message__list .simplebar-content-wrapper"),
                                dealRules = '';

                            list.append(
                                "<div class='message  group' msg-id='" + data.msg_id + "'>" +
                                "<div class='message__photo'>" +
                                "<img src='" + $("#my-chat-img").text() + "' class='img-responsive img-circle'>" +
                                "<time datetime data-time='" + data.timestamp + "'>" + data.created_at + "</time>" +
                                "</div>" +
                                "<div class='message__text'>" +
                                "<div class='inner'>" + data.msg + "<span class='mobile-msg-time'>" + data.created_at + "</span></div>" +
                                "</div>" +
                                "</div>"
                            );

                            $(".friend.group[data-id='" + data.msg_to + "']").insertBefore('.friend.group:first');
                            $(".friend.group[data-id='" + data.msg_to + "'] .friend__time").text(data.created_at).attr('msg_id', data.msg_id).attr('data-time', data.timestamp);

                            if (data.social == 'in' || data.social == 'twitter') {
                                dealRules =
                                    "<ol>" +
                                    "<li>The buyer pays a 7% ($3 minimum) service fee.</li>" +
                                    "<li>The seller transfers login details and the original email account to the escrow agent.</li>" +
                                    "<li>The escrow agent checks everything, changes the login details, and tells the buyer to pay the seller.</li>" +
                                    "<li>The buyer pays the seller.</li>" +
                                    "<li>After the seller’s confirmation, the system sends the new login details to the buyer.</li>" +
                                    "</ol>";
                            } else if (data.social == 'fb') {
                                dealRules =
                                    "<ol>" +
                                    "<li>The buyer pays a 7% ($3 minimum) service fee.</li>" +
                                    "<li>The seller assigns the escrow agent’s page as the administrator.</li>" +
                                    "<li>The escrow agent checks everything, removes the other administrators, and tells the buyer to pay the seller.</li>" +
                                    "<li>The buyer pays the seller.</li>" +
                                    "<li>After the seller’s confirmation, the escrow agent assigns the buyer’s page as the administrator.</li>" +
                                    "</ol>";
                            } else if (data.social == 'tg') {
                                dealRules =
                                    "<ol>" +
                                    "<li>The buyer pays a 7% ($3 minimum) service fee.</li>" +
                                    "<li>The seller sends the account creator’s phone number to the escrow agent.</li>" +
                                    "<li>In order to login, the escrow agent asks for a verification code that is sent to the account creator’s phone number.</li>" +
                                    "<li>The escrow agent then connects their phone number and tells the buyer to pay the seller.</li>" +
                                    "<li>The buyer pays the seller.</li>" +
                                    "<li>After the seller’s confirmation, the escrow agent connects the buyer’s phone number.</li>" +
                                    "</ol>";
                            } else if (data.social == 'youtube') {
                                dealRules =
                                    "<ol>" +
                                    "<li>The buyer pays a 7% ($3 minimum) service fee.</li>" +
                                    "<li>The seller assigns the escrow agent as a manager.</li>" +
                                    "<li>After 7 days, the seller assigns primary ownership rights to the escrow agent (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel.)</li>" +
                                    "<li>The escrow agent verifies everything, removes the other managers, and notifies the buyer to pay the seller.</li>" +
                                    "<li>The buyer pays the seller.</li>" +
                                    "<li>After the seller’s confirmation, the escrow agent assigns ownership rights to the buyer.</li>" +
                                    "</ol>";
                            }

                            list.find('.message.group:last').after(
                                "<div class='garant-container' data-social='" + data.social + "' data-id='" + data.garant_id + "'>" +
                                "<div class='deal-desc'>" +
                                "<h4>Request to purchase \"<a target='_blank' href='/group/" + data.group_id + "'>" + data.name + "</a>\"</h4>" +
                                "<p><b>Transaction ID:</b> " + data.garant_id + "</p>" +
                                "<p><b>Transaction amount:</b> $<span class='deal-amount-span'>" + data.amount + "</span></p>" +
                                "<div class='deal-desc__title'>Transaction steps when using the escrow service:</div>" +
                                dealRules +
                                "</div>" +
                                "<div class='deal-comment'>" +
                                "<p>Waiting for seller to agree to the terms of the transaction.</p>" +
                                "</div>" +
                                "<div class='deal-actions'>" +
                                "<div class='deal-action group'>" +
                                "<div class='deal-cheat'>" +
                                "<a href='#'>I’ve been tricked! / There’s been some kind of problem - contact a live escrow agent</a>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                            );

                            $(".garants-bar[data-id='" + data.msg_to + "'] ul").append(
                                "<li data-id='" + data.garant_id + "'>" +
                                "<b>ID" + data.garant_id + "</b> " +
                                data.name +
                                "</li>"
                            );

                            list.append(
                                "<div class='message system group'>" +
                                "<div class='message__photo'>" +
                                "<img src='/images/friend3.png' class='img-responsive img-circle'>" +
                                "<time datetime data-time='" + data.timestamp + "'>1 sec</time>" +
                                "</div>" +
                                "<div class='message__text'>" +
                                "<div class='inner'>Be careful! All messages from the escrow agent have a black foreground to help identify them, so it’s impossible to confuse them with a regular message. Besides the escrow agent, there are no other third parties! REGULAR users’ messages appear with a white background! When the buyer has paid the seller, the transaction's status will be updated accordingly. If a dispute arises and it turns out that the transaction was not performed according to the rules specified above, the seller will be held responsible.<span class='mobile-msg-time'>1 sec</span></div>" +
                                "</div>" +
                                "</div>"
                            );

                            setTimeout(function() {
                                list.find(".message.mine.group.typing").insertAfter(list.find('> div:last'));
                            }, 3000);

                            list.animate({
                                scrollTop: list[0].scrollHeight
                            }, 500);

                            console.log('huy');

                            if (data.msg_register) {
                                adjustMessageListHeight();
                            }

                            $(".chat__messages[data-id='" + data.msg_to + "'] textarea").focus();
                            $(".friend.group[data-id='" + data.msg_to + "'] .friend__name + p").text(data.msg);
                        });
                    }
                }).fail(function() {
                    unknowError();
                    preloader.hide();
                    button.show();
                });
        }

        $("#modal3 form").on('submit', function(e) {
            e.preventDefault();

            var message = $(this).find('textarea').val(),
                garant = $(this).find("input[name='use_guard']").is(':checked'),
                button = $(this).find("button[type='submit']"),
                preloader = $(".deal-request-preloader"),
                modal = $("#modal3"),
                error = false,
                info = null;

            if (!message) {
                setNoty('You forgot to write a message to the seller.', 'error');
            } else {
                if (garant) {
                    var transfer = $(this).find("select[name='transfer']").val(),
                        groupId = $(this).attr('data-id'),
                        social = $("body").attr('data-social'),
                        payments = modal.find("#choose-payment-methods-boxes li.active"),
                        input = '';

                    if (transfer == 0 || social == 'tg' || social == 'youtube') {
                        input = $(this).find("input[name='phone']");
                        if (!transfer) transfer = 0;
                    } else {
                        if (social != 'vk') {
                            transfer = 1;
                        }
                        input = $(this).find("input[name='account']");
                    }

                    if (social != 'in' && social != 'twitter') {
                        info = input.val();

                        if (validateInfoField(transfer, input, info, social) == 'stop') {
                            error = true;
                        }
                    }

                    if (!payments.length) {
                        setNoty("You forgot to select payment methods", 'error');
                        error = true;
                    } else {
                        var paymentIds = [];
                        $.each(payments, function() {
                            paymentIds.push($(this).attr('data-id'));
                        });
                    }

                    if (error) {
                        preloader.hide();
                        button.show();
                        return false;
                    }

                    if (modal.attr('data-terms')) {
                        button.hide();
                        preloader.css('display', 'block');

                        createGarant(groupId, message, transfer, info, button, paymentIds, preloader, button);
                    } else {
                        var modal = $('#policy-modal');

                        if (social == 'tg') {
                            modal.find(".garant-terms-warning").hide();
                            modal.find(".policy-container").css("height", '75vh');
                        } else {
                            modal.find(".garant-terms-warning").show();
                            modal.find(".policy-container").css("height", '65vh');
                        }

                        modal.find(".policy-container > div").hide();
                        modal.find(".garant-terms-text").show();
                        modal.find("button").attr('data-type', 'garant-request').text("I have read and agree to the terms and conditions");
                        modal.modal('show');
                    }
                } else {
                    var toId = button.attr('data-user-id');

                    $.when(sendMessage(toId, message))
                        .done(function(data) {
                            modal.modal('hide');
                            preloader.hide();
                            button.show();

                            $.when(loadDialogs('start')).then(function() {
                                return createDialogChat(button);
                            }).done(function() {

                                if ($(".chat__messages[data-id='" + toId + "']").length && !$(".message.group[msg-id='" + data.msg_id + "']").length) {

                                    var list = $(".chat__messages[data-id='" + toId + "'] .message__list .simplebar-content-wrapper");

                                    list.append(
                                        "<div class='message  group' msg-id='" + data.msg_id + "'>" +
                                        "<div class='message__photo'>" +
                                        "<img src='" + $("#my-chat-img").text() + "' class='img-responsive img-circle'>" +
                                        "<time datetime data-time='" + data.timestamp + "'>1 sec</time>" +
                                        "</div>" +
                                        "<div class='message__text'>" +
                                        "<div class='inner'>" + data.msg + "<span class='mobile-msg-time'>1 sec</span></div>" +
                                        "</div>" +
                                        "</div>"
                                    );

                                    $(".friend.group[data-id='" + toId + "']").insertBefore('.friend.group:first');
                                    $(".friend.group[data-id='" + toId + "'] .friend__time").attr('msg-id', data.msg_id)
                                    $(".friend.group[data-id='" + toId + "'] .friend__time").text('1 sec');

                                    list.find(".message.mine.group.typing").insertAfter(list.find('> div:last'));

                                    $(".friend.group[data-id='" + toId + "'] .friend__name + p").html(message);

                                    list.animate({
                                        scrollTop: list[0].scrollHeight
                                    }, 10);
                                }
                            });

                        });
                }
            }
        });
    </script>

    <script>
        $("#policy-modal button").on('click', function() {
            var btn = $(this),
                type = btn.attr('data-type');

            $("#policy-modal").modal('hide');

            if (type == 'garant-request') {
                var modal = $("#modal3");
                modal.modal('show');
                modal.attr('data-terms', 1);
                modal.find("form").submit();
            } else if (type == 'garant-fast') {
                $("#fast-deal-form button").attr('data-terms', 1).click();
            } else if (type == 'accept-condition') {
                $(".garant-container[data-id='" + btn.attr('data-id') + "'] .accept-condition-btn a").attr('data-terms', 1).click();
            }
        });
    </script>

    <script>
        Dropzone.autoDiscover = false;

        var attachFilesDropzone = null;

        $("#attachFilesDropzone").dropzone({
            url: "/upload_chat_files",
            params: function(files, xhr, chunk) {
                if (chunk) {
                    return {
                        upload_id: chunk.file.upload.uuid,
                        size: chunk.file.size,
                        offset: chunk.index * this.options.chunkSize,
                        tmp_id: $("#attach-files-modal").attr('data-tmp'),
                        to_id: $("#attach-files-modal").attr('data-to'),
                        _token: csrf
                    };
                } else {
                    return {
                        _token: csrf
                    }; // for test
                }
            },
            timeout: 100000,
            dictRemoveFile: 'Remove',
            dictCancelUpload: 'Cancel',
            addRemoveLinks: true,
            maxFilesize: 500, // max individual file size 500 MB
            chunking: true,
            forceChunking: true,
            chunkSize: 1000000,
            init: function() {
                this.on("addedfiles", function(file, progress, bytesSent) {
                    // this.options.params.size = bytesSent;
                    // this.options.params.offset =
                    // dzChunkByteOffset: chunk.index * this.options.chunkSize
                });
            },
            removedfile: function(file) {
                var el = $(file.previewElement),
                    id = el.attr('data-id');

                if (id) {
                    $.ajax({
                        url: '/delete_chat_uploaded_file',
                        method: 'POST',
                        data: {
                            id: el.attr('data-id'),
                            _token: csrf
                        }
                    }).fail(function() {
                        unknowError();
                    });
                }

                el.remove();
            },
            success: function(file) {
                var response = JSON.parse(file.xhr.response);

                if (response[0] == 'error') {
                    setNoty(response[1], 'error');
                    return file.previewElement.classList.add("dz-error");
                } else {
                    $(file.previewElement).attr('data-id', response[1]['id']);
                    return file.previewElement.classList.add("dz-success");
                }
            },
            error: function(file) {
                if (file.status != "canceled") {
                    setNoty("An error occurred while uploading the file. Delete it and try uploading again.", 'error');
                    return file.previewElement.classList.add("dz-error");
                }
            }
        });

        function getOptimizationStatus(msgEl) {
            var getOptimizationStatus = setInterval(function() {
                var uploadIds = [];

                msgEl.find("div[data-status='transcoding']").each(function() {
                    uploadIds.push($(this).attr('data-id'));
                });

                if (uploadIds.length) {
                    $.ajax({
                        url: '/get_video_optimization_status',
                        method: 'POST',
                        data: {
                            upload_ids: uploadIds,
                            _token: csrf
                        }
                    }).done(function(data) {
                        $.each(data.uploads, function() {
                            if (this.status == 'available') {
                                msgEl.find("div[data-id='" + this.id + "']").attr('data-status', 'available').html(this.player);
                            } else if (this.status != 'transcoding' && this.status != 'transcode_starting') {
                                msgEl.find("div[data-id='" + this.id + "']").attr('data-status', 'available').html(this.player);
                                setNoty("An error occurred while optimizing the video.", "error");
                            }
                        });
                    });
                } else {
                    clearInterval(getOptimizationStatus);
                }
            }, 5000);
        }

        function adjustMultiMediaMessageWitdth(inner) {

            setTimeout(function() {
                inner.css('width', 'initial');

                var width = inner.width(),
                    windowWidth = $(window).width(),
                    adminMsg = inner.closest('.message').hasClass('system'),
                    imgWidth = 246;

                if (windowWidth <= 491 || (windowWidth >= 992 && windowWidth <= 1046)) {
                    if (inner.hasClass('two-media') || inner.hasClass('multiple-media')) {
                        imgWidth = 136;
                    }
                } else {
                    if (inner.hasClass('two-media')) {
                        imgWidth = 196;
                    } else if (inner.hasClass('multiple-media')) {
                        imgWidth = 176;
                    }
                }

                var maxImagesInRow = Math.floor(width / imgWidth);

                inner.css('width', maxImagesInRow * imgWidth + (adminMsg ? 4 : 0));

            }, 100);
        }

        $(window).on('resize', function() {
            $.each($(".inner.multiple-media, .inner.two-media"), function() {
                adjustMultiMediaMessageWitdth($(this));
            });
        });

        $("#attach-files-modal .send-message-btn").on('click', function() {
            sendChatFiles();
        });

        $(document).keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13' && $("#attach-files-modal").is(":visible")) {
                sendChatFiles();
            }
        });

        $(document).on('click', ".group-page .screen, .media .inner div[data-type='image']", function() {
            var modal = $("#screen-modal"),
                path = $(this).attr('data-path'),
                windowWith = $(window).width(),
                windowHeight = $(window).height();

            var actualImage = new Image();
            actualImage.src = path;

            modal.modal('show');

            actualImage.onload = function() {
                var width = this.width,
                    height = this.height;

                var screenWidth = windowWith * (windowWith > 800 ? 0.7 : 0.9),
                    screenHeight = height / width * screenWidth;

                if (screenHeight > 0.9 * windowHeight) {
                    screenHeight = windowHeight * 0.9;
                    screenWidth = width / height * screenHeight;
                }

                modal.find(".modal-block__content").css({
                    width: screenWidth + 'px',
                    height: screenHeight + 'px',
                    'background-image': 'url(' + path + ')'
                });
            }
        });

        function sendChatFiles() {
            var modal = $("#attach-files-modal"),
                tmpId = modal.attr('data-tmp'),
                toId = modal.attr('data-to'),
                fromId = modal.attr('data-from'),
                dropzone = $('#attachFilesDropzone'),
                dz = dropzone[0].dropzone;

            if (!dz.files.length) {
                setNoty("You haven't uploaded any files.", 'error');
            } else if (dz.getUploadingFiles().length === 0 && dz.getQueuedFiles().length === 0) {
                sendChatMessage(toId, fromId, '', tmpId);
                modal.attr('data-tmp', uniqueId());
                modal.modal('hide');
                clearDropzone(dropzone);
            } else {
                setNoty('Please wait until all files have finished uploading, or cancel ongoing uploads.', 'warning');
            }
        }

        function clearDropzone(dropzone) {
            dropzone.removeClass('dz-started');
            dropzone[0].dropzone.files.forEach(function(file) {
                file.previewElement.remove();
            });
        }
    </script>





    <script>
        $(".verificate-btn").on('click', function(e) {
            e.preventDefault();

            var modal = $($(this).attr('href')),
                social = $(this).attr('data-social'),
                text = 'description';

            if (social == 'in' || social == 'twitter') {
                text = "\"Bio\" section";
            }

            modal.find(".modal-submit a").attr('data-id', $(this).attr('data-id'));

            modal.find(".modal-testing span").text(text);
            modal.find(".modal-test_code").text($(this).attr('data-status'));

            modal.modal('show');
        });

        $("#modal10 .violet").on('click', function(e) {
            e.preventDefault();

            var modal = $("#modal10"),
                preloader = modal.find(".deal-request-preloader"),
                label = modal.attr('data-label'),
                amount = modal.attr('data-amount'),
                btn = $(this),
                choosed = modal.find("select").val();

            payOrder(choosed, amount, label, btn, preloader, 'pro');
        });

        $("#modal16 a, #modal17 a").on('click', function(e) {
            e.preventDefault();

            var groupId = $(this).attr('data-id'),
                modal = $(this).closest('.modal-block'),
                type = modal.attr('id');

            $.ajax({
                    url: '/group/verification',
                    method: 'POST',
                    data: {
                        group_id: groupId,
                        _token: csrf
                    }
                })
                .done(function(data) {
                    if (data == 'verified') {
                        setNoty('Listing verified successfully.', 'success');
                        modal.modal('hide');
                    } else {
                        setNoty('Code in the page not found.', 'error');
                    }
                });
        });

        $('.edit-group').on('click', function(e) {
            e.preventDefault();

            var data = JSON.parse($(this).attr('data-data')),
                donate = $(this).attr('data-donate') ? JSON.parse($(this).attr('data-donate')) : null,
                modal = $('#modal5');

            modal.find('.modal-block__title').text(data.name);
            modal.find("select[name='subject']").val(data.subject).trigger('change');
            modal.find("input[name='price']").val(data.price);
            modal.find("input[name='subscribers']").val(data.subscribers);
            modal.find("input[name='gain']").val(data.gain);
            modal.find("input[name='expense']").val(data.expense);
            modal.find("textarea[name='description']").val(data.description);
            modal.find("input[name='promote']").val(data.promote);
            modal.find("input[name='expense_origin']").val(data.expense_origin);
            modal.find("input[name='gain_origin']").val(data.gain_origin);
            modal.find("input[name='content']").val(data.content);
            modal.find("input[name='supporting']").val(data.supporting);
            modal.find("input[name='id']").val(data.id);


            modal.find(".monetization").hide();
            modal.find(".original_email").hide();

            if (data.show_link) {
                modal.find("#show-link").prop('checked', 'checked');
            } else {
                modal.find("#show-link").prop('checked', false);
            }

            if (data.comment) {
                modal.find("#comment").prop('checked', 'checked');
            } else {
                modal.find("#comment").prop('checked', false);
            }

            if (data.content == null) data.content = 'choose';

            if (data.social == 'in') {
                modal.find(".original_email select").val(data.original_email).change();
                modal.find(".original_email").show();
            } else if (data.social == 'youtube') {
                modal.find(".monetization select").val(data.monetization).change();
                modal.find(".monetization").show();
            }

            $("#single-select2-modal-edit").val(null).val(data.content);
            $(".select2-select-modal, #single-select2-modal-edit").trigger('change');

            setTimeout(function() {
                $(".select2-selection__choice__remove").each(function() {
                    $(this).attr('class', 'select2-selection__choice__remove_modal');
                });
            }, 200);

            $(".select2-search__field").hide();
            $(".select2-selection--multiple").css('padding-bottom', '5px');

            if (data.social == 'fb' && data.link.match('groups/index.html')) {
                modal.find("input[name='subscribers']").removeAttr('readonly')
            } else {
                modal.find("input[name='subscribers']").attr('readonly', 'readonly')
            }

            modal.modal('show');
        });

        $("#confirm-order-modal button").on('click', function() {
            $($(this).attr('data-form')).submit();
        });

        function initPayPalModal(id, amount, type) {
            var modal = $("#modal10");

            $(".modal-paypal-btn").empty();

            amount = parseFloat(amount);

            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: Math.round((amount + 0.30 + amount * 0.029) * 10) / 10
                            },
                            custom_id: id
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function() {
                        var paypalOrderId = data.orderID;

                        setNoty("You’ve paid. We’re processing your payment...", 'success');

                        $.ajax({
                            url: "/pay",
                            method: 'POST',
                            data: {
                                order_id: paypalOrderId
                            }
                        }).done(function(data) {
                            if (data[0] == 'error') {
                                setNoty(data[1], 'error');
                            } else {
                                modal.modal('hide');
                                if (type == 'donate') {
                                    setNoty("Listing successfully pinned/highlighted with color.", 'success');
                                } else if (type == 'donate_before') {
                                    setNoty("Done. Now remember to create the listing again! The limit will be lifted, and it will be pinned automatically.", 'success');
                                    $("#modal18").modal('hide');
                                } else {
                                    setNoty("You’ve successfully obtained " + type + " status.", 'success');
                                }
                            }
                        }).fail(function() {
                            unknowError();
                        });
                    });
                }
            }).render('#modal10 .modal-paypal-btn');

            modal.modal('show');
        }

        function payOrder(choosed, amount, label, button, preloader, paymentType) {
            amount = parseFloat(amount);

            button.hide();
            preloader.show();

            $.ajax({
                    url: '/pay/order',
                    method: 'POST',
                    data: {
                        label: label,
                        type: choosed,
                        amount: amount,
                        _token: csrf
                    }
                })
                .fail(function() {
                    unknowError();
                    preloader.hide();
                    button.show();
                })
                .done(function(data) {
                    if (data[0] && data[0] == 'error') {
                        setNoty(data[1], 'error');
                        preloader.hide();
                        button.show();
                        return false;
                    }

                    if (choosed == 4) {
                        balancePay(data[0], button, preloader);
                    } else {
                        var confirmModal = $("#confirm-order-modal"),
                            payeerReg = confirmModal.find(".payeer-registration"),
                            nonUs = confirmModal.find(".non-us-warning"),
                            formId = "#hidden-payment-form",
                            paymentForm = $(formId),
                            type = null;

                        confirmModal.find(".modal-block__content *").show();
                        confirmModal.find("button").attr('data-type', paymentType);
                        payeerReg.hide();
                        nonUs.hide();

                        if (choosed == 1) {
                            paymentForm.attr('action', data[1]);
                            type = "Crypto";
                        } else if (choosed == 0 || choosed == 2) {
                            if (choosed == 0) {
                                type = "Visa/MasterCard";
                            } else if (choosed == 2) {
                                type = "PayOp";
                            }

                            paymentForm.attr('action', "https://payop.com/en/payment/invoice-preprocessing/" + data[1]);
                        } else if (choosed == 3) {
                            formId = "#payeer-form",
                                paymentForm = $(formId);
                            var payeerData = data[1];

                            paymentForm.find('[name="m_orderid"]').val(data[0]);
                            paymentForm.find('[name="m_amount"]').val(payeerData.amount);
                            paymentForm.find('[name="m_desc"]').val(payeerData.description);
                            paymentForm.find('[name="m_sign"]').val(payeerData.sign);
                            paymentForm.find('[name="m_curr"]').val(payeerData.currency);

                            // payeerReg.show();

                            type = "E-wallets (Payeer)";

                            // nonUs.show();
                        } else if (choosed == 5 || choosed == 6 || choosed == 7 || choosed == 8 || choosed == 9 || choosed == 10) {
                            formId = "#advcash-form";

                            var advForm = $(formId),
                                advData = data[1];

                            amount = advData.amount;
                            advForm.find("[name='ac_sci_name']").val(advData.method);
                            advForm.find("[name='ac_amount']").val(amount);
                            advForm.find("[name='ac_currency']").val(advData.currency);
                            advForm.find("[name='ac_order_id']").val(advData.order_id);
                            advForm.find("[name='ac_sign']").val(advData.sign);
                            advForm.find("[name='ac_comments']").val('Payment for order id' + advData.order_id);

                            if (paymentType == 'garant') {
                                advcashRefund.find('span').show();
                            }

                            type = "Visa/MasterCard";

                            // nonUs.show();
                        } else if (choosed == 11) {
                            formId = "#enot-form";

                            var enotForm = $(formId),
                                enotData = data[1];

                            amount = enotData.amount;

                            enotForm.find("[name='m']").val(enotData.shop_id);
                            enotForm.find("[name='o']").val(enotData.order_id);
                            enotForm.find("[name='oa']").val(amount);
                            enotForm.find("[name='s']").val(enotData.sign);
                            enotForm.find("[name='p']").val(enotData.method);
                            enotForm.find("[name='cf']").val(enotData.custom_field);

                            // nonUs.show();

                            type = "Visa/MasterCard";
                        } else if (choosed == 13) {
                            formId = "#interkassa-form";

                            var interkassaForm = $(formId),
                                interkassaData = data[1];

                            amount = interkassaData.ik_am;

                            interkassaForm.find("[name='ik_co_id']").val(interkassaData.ik_co_id);
                            interkassaForm.find("[name='ik_pm_no']").val(interkassaData.ik_pm_no);
                            interkassaForm.find("[name='ik_am']").val(interkassaData.ik_am);
                            interkassaForm.find("[name='ik_desc']").val(interkassaData.ik_desc);
                            interkassaForm.find("[name='ik_cur']").val(interkassaData.ik_cur);
                            interkassaForm.find("[name='ik_sign']").val(interkassaData.ik_sign);

                            type = "Visa/MasterCard (ONLY 3DS ALLOWED CARDS)";
                        }

                        if (choosed == 6) {
                            amount += ' EUR';
                        } else if (choosed == 7) {
                            amount += ' GBP';
                        } else if (choosed == 8) {
                            amount += 'RUB';
                        } else if (choosed == 9) {
                            amount += ' TRY';
                        } else if (choosed == 10) {
                            amount += ' BRL';
                        } else {
                            amount = '$' + amount;
                        }

                        confirmModal.find('p[data-type="order-id"] span').text(data[0]);
                        confirmModal.find('p[data-type="amount"] span').text(amount);
                        confirmModal.find('p[data-type="type"] span').text(type);
                        confirmModal.find("button").attr('data-form', formId);

                        confirmModal.modal('show');

                        preloader.hide();
                        button.show();
                    }
                });
        }

        function balancePay(order, toHide, preloader) {
            $.ajax({
                url: "/balance/pay",
                data: {
                    order: order,
                    _token: csrf
                },
                method: 'POST'
            }).always(function() {
                if (toHide) {
                    toHide.show();
                    preloader.hide();
                }
            }).done(function(data) {
                if (data[0] == 'success') {
                    setNoty('Service successfully paid.', 'success');
                    $("#modal10").modal('hide');
                } else if (data[0] == 'not enough') {
                    var modal = $("#modal10"),
                        amount = data[1],
                        label = data[2];

                    modal.attr('data-amount', amount);
                    modal.attr('data-label', label);
                    modal.modal('show');
                    modal.find("option[value='4']").remove();
                    modal.attr('data-type', 'not_enough')
                    modal.find(".modal-block__title")
                        .text("There is not enough $" + amount + " on your balance, but you can pay the missing amount")
                        .css('font-size', '17px');

                    modal.find('select').select2({
                        minimumResultsForSearch: -1
                    });
                } else if (data[0] == 'error') {
                    setNoty(data[1], 'error');
                }
            }).fail(function() {
                unknowError();
            });
        }

        $(document).on('hidden.bs.modal', "#modal10", function() {
            var modal = $("#modal10"),
                select = modal.find('select');


            modal.find(".modal-block__title").text('Select a payment method').css('font-size', '21px');
        });

        $("#balance-add-modal .violet").on('click', function(e) {
            e.preventDefault();

            var amount = parseFloat($("input[name='add-amount']").val()),
                modal = $(this).closest("#balance-add-modal"),
                button = $(this),
                preloader = modal.find(".deal-request-preloader"),
                choosed = modal.find("select[name='payment-method']").val(),
                label = {
                    type: 'balance',
                    user_id: 1490768728
                };

            if (!amount) {
                setNoty('You forgot to enter the amount.', 'error');
                return false;
            } else if (amount < 1) {
                setNoty('The minimum amount is $1.', 'error');
                return false;
            }

            payOrder(choosed, amount, JSON.stringify(label), button, preloader, 'balance');
        });
    </script>
    <!-- Scripts -->
    <script>
        var registerCaptcha = "",
            loginCaptcha = "";

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(".scroll_down").on('click', function(e) {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: $(".posts-list__filter").offset().top - 20
            }, 600);
        });

        $(document).ready(function() {
            setTimeout(function() {
                $("select[name='theme[]']").val(JSON.parse('null')).change();
                $("select[name='transfer[]']").val(JSON.parse('null')).change();
            }, 10);

            setTimeout(function() {
                registerCaptcha = grecaptcha.render('register-captcha', {
                    'sitekey': '6Leo36EUAAAAAE0ZOrWXFQ_FI4pA8lRXkNe3-T7V',
                });
                loginCaptcha = grecaptcha.render('login-captcha', {
                    'sitekey': '6Leo36EUAAAAAE0ZOrWXFQ_FI4pA8lRXkNe3-T7V',
                });
            }, 2000);
        });
    </script>

    <script>
        var checkCaptcha = true;
    </script>
    <script src="js/login_regiter2048.js?v=1.5"></script>
    <script>
        $('.js-sell-community').on('click', function(e) {
            e.preventDefault();
            $('#js-modal1').trigger('click');
        });
        new Authenticate('#modal-container');
    </script>
