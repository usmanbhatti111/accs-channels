<footer class="footer">
        <div class="container group">
            <a href="index.html" class="footer__logo"></a>
            <div class="footer_button">
                <a href="login.html" class="js-sell-community">Start selling</a>
            </div>

            <div class="footer__nav">
                <nav>
                    <ul>
                        <li><a href="about.html">About us</a></li>
                        <li><a href="escrow.html">Escrow service</a></li>
                        <li><a href="sellers.html">Sellers</a></li>

                        <li><a href="contact-us.html">Contact us</a></li>
                    </ul>
                </nav>
            </div>
            <div id="policy-footer-block">
                <div class="ur-info">
                    <p>MetaSwap LP</p>
                    <p>Address: 91 Battersea Park Road, London, England, SW8 4DU</p>
                </div>
                <div id="footer-policy">
                    <div data-type="1">

                        <a href="services-terms.html">Terms and Conditions</a>
                        <a href="privacy.html">Privacy Policy</a>
                    </div>

                </div>
            </div>
            <hr>
        </div>


        <script src="js/dropzone.js"></script>








        <script>
            // @see  https://docs.headwayapp.co/widget for more configuration options.
            var HW_config = {
                selector: ".announcekit-widget", // CSS selector where to inject the badge
                account: "J3Q2Yxf"
            }
        </script>
        <script async src="../cdn.headwayapp.co/widget.js"></script>
        <script src="../www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
        <script src="../www.gstatic.com/firebasejs/8.10.1/firebase-analytics.js"></script>
        <script src="../www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>
        <script>


        </script>
        <script>
            function gtag_report_conversion(conversion_id) {
                if (conversion_id) {
                    // сначала проверяем не была ли уже отмечена в гугл эта конверсия
                    $.ajax({
                        url: '/check_google_conversion',
                        method: 'POST',
                        data: {
                            id: conversion_id,
                            _token: csrf
                        }
                    }).done(function(data) {
                        if (data.status == 'ok') {
                            var sendTo = 'AW-733613875/' + data.event_id,
                                params;

                            if (data.amount) {
                                params = {
                                    'send_to': sendTo,
                                    'transaction_id': data.order_id + '',
                                    'value': data.amount,
                                    'currency': 'USD'
                                };
                            } else {
                                params = {
                                    'send_to': sendTo
                                };
                            }

                            gtag('event', 'conversion', params);
                        }
                    }).fail(function() {
                        unknowError();
                    });
                }
            }

            var uniqueId = function() {
                return Date.now().toString(36) + Math.random().toString(36).substr(2);
            }

            function now() {
                return Math.floor(Date.now() / 1000);
            }
        </script>
        <script async src="../cdn.announcekit.app/widget-v2.js"></script>
        <script>
            function setNoty(msg, type, noAudio) {
                new Noty({
                    type: type,
                    timeout: 5000,
                    text: msg
                }).show();

                if (!noAudio && type == 'success') {
                    notyAudio();
                }
            }

            socket.on('read', function(data) {
                console.log(data);
                readMessages(data.message_ids, 'data-read');
                readMessages(data.admin_read_message_ids, 'data-admin-read');
                readMessages(data.from_message_ids, 'data-from-read');
            });

            function readMessages(messageIds, attr) {
                $.each(messageIds, function() {
                    var message = $(".message[msg-id='" + this + "']"),
                        notReadyMessageIds = [];

                    if (message.length) {
                        message.attr(attr, 1);
                    } else {
                        notReadyMessageIds.push(this);
                    }

                    setTimeout(function() {
                        $(notReadyMessageIds).each(function() {
                            var message = $(".message[msg-id='" + this + "']");
                            message.attr(attr, 1);
                        });
                    }, 5000);
                });
            }

            var readTimeout = null;

            function chatRead() {
                if (readTimeout != null) {
                    clearTimeout(readTimeout);
                }

                var chat = $('.chat__messages:visible');

                if ($("#chat1").hasClass('admin-chat')) {
                    var newMessages = chat.find(".message:not(.system):not(.typing):not([data-read='1'])");
                } else {
                    var newMessages = chat.find(".mine:not(.typing):not([data-read='1']), .system:not([data-read='1'])");
                }

                $.each(newMessages, function() {
                    if (isIntoView($(this))) {
                        $(this).attr('data-read', 1).attr('data-new-read', 1);
                    }
                });

                readTimeout = setTimeout(function() {
                    var newMessages = chat.find(".message[data-new-read='1']"),
                        newMessageIds = [];

                    $(newMessages).each(function() {
                        newMessageIds.push($(this).attr('msg-id'));
                        $(this).removeAttr('data-new-read');
                    });

                    if (newMessageIds.length) {
                        setTimeout(function() {
                            var chatId = chat.attr('data-chat');
                            $.ajax({
                                url: "/chat/read",
                                data: {
                                    chat_id: chatId,
                                    new_message_ids: newMessageIds,
                                    _token: csrf
                                },
                                method: 'POST'
                            }).done(function(data) {
                                var el = $(".chat-button1 span"),
                                    dialog = $(".friend.group[data-chat_id='" + chatId + "']");

                                dialog.find(".friend__noty").text(data.unread);
                                el.text(data.total_unread);

                                dialog.attr('data-noty', data.unread != 0 ? 1 : 0);

                                if (data.total_unread != 0) {
                                    el.show();
                                } else {
                                    el.hide();
                                }
                            });
                        }, 10);
                    }
                }, 500);
            }

            function readIcons() {
                if ($("#chat1").hasClass('admin-chat')) {
                    return "<div class='read-icons'>" +
                        "<img src='/images/sent-white.png' class='message-sent-seller'>" +
                        "<img src='/images/read-white.png' class='message-read-seller'>" +
                        "<img src='/images/sent-blue.png' class='message-sent-buyer'>" +
                        "<img src='/images/read-blue.png' class='message-read-buyer'>" +
                        "<img src='/images/sent-black.png' class='message-sent black'>" +
                        "<img src='/images/read-black.png' class='message-read black'>" +
                        "<img src='/images/sent-white.png' class='message-sent white'>" +
                        "<img src='/images/read-white.png' class='message-read white'>" +
                        "</div>";
                } else {
                    return "<div class='read-icons'>" +
                        "<img src='/images/sent-black.png' class='admin-message-sent'>" +
                        "<img src='/images/read-black.png' class='admin-message-read'>" +
                        "<img src='/images/sent-blue.png' class='message-sent blue'>" +
                        "<img src='/images/read-blue.png' class='message-read blue'>" +
                        "<img src='/images/sent-white.png' class='message-sent white'>" +
                        "<img src='/images/read-white.png' class='message-read white'>" +
                        "</div>";
                }
            }

            function getDayStr(days) {
                var days_str = "";

                if (days > 1) {
                    days_str = 'days';
                } else {
                    days_str = 'day';
                }

                return days_str;
            }

            function notyAudio() {
                var audio = $("#chat-audio");

                if (audio.length) {
                    $("#chat-audio")[0].play();
                }
            }

            function unknowError() {
                setNoty('An unknown error has occurred. Please contact the administrator.', 'error');
            }

            function drawChatUploads(uploads) {
                var mediaFiles = "",
                    mediaQuantity = "",
                    filesCount = 0;

                if (uploads) {
                    filesCount = uploads.length;

                    if (filesCount) {
                        $.each(uploads, function() {
                            if (this.type == 'image') {
                                mediaFiles += "<div class='media-item' data-type='image' data-path='" + this.path + "' data-id='" + this.id + "' style='background-image: url(" + this.path + ")'></div>";
                            } else if (this.type == 'video') {
                                mediaFiles += "<div class='media-item' data-type='video' data-status='" + this.video_status + "' data-id='" + this.id + "'>";
                                if (this.video_status == 'transcoding') {
                                    mediaFiles += "<img class='chat-media-preloader' src='/images/dialogs_preloader.gif' alt='Loading...'>";
                                } else {
                                    mediaFiles += this.path;
                                }
                                mediaFiles += "</div>";
                            }
                        });

                        if (filesCount == 2) {
                            mediaQuantity = "two-media";
                        } else if (filesCount > 2) {
                            mediaQuantity = "multiple-media";
                        }
                    }
                }

                return {
                    mediaQuantity: mediaQuantity,
                    mediaFiles: mediaFiles,
                    filesCount: filesCount
                };
            }

            $(document).on('click', "[data-clipboard='true']", function() {
                $(this).select();
                document.execCommand("copy");
                setNoty('Copied to clipboard', 'success', true);
            });

            function validateInfoField(transfer, input, info, social) {
                var borderRed = false,
                    error = [];

                if (social == 'twitter' || social == 'in') return 'ok';

                if (!info) {
                    var infoType = "phone number to associate with the account";

                    if (transfer > 0 || (social != 'vk' && social != 'tg' && social != 'youtube')) {
                        infoType = "page to which you want to transfer administrative rights";
                    } else if (social == 'youtube') {
                        infoType = "email to which you want to transfer administrative rights";
                    }

                    borderRed = true;
                    error.push('You’ve forgotten to provide the ' + infoType + '.');
                } else {
                    if (social == 'fb') {
                        if (!info.match(/facebook\.com\/.*/im)) {
                            borderRed = true;
                            error.push('The Facebook link you’ve provided is formatted incorrectly.');
                        }
                    } else if (social == 'tg') {
                        if (!info.match(/^(\s+)?[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}(\s+)?$/im)) {
                            borderRed = true;
                            error.push('You’ve provided an invalid phone number.');
                        }
                    } else if (social == 'youtube') {
                        if (!info.match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/im)) {
                            borderRed = true;
                            error.push('You’ve provided an invalid email address.');
                        }
                    }
                }

                if (borderRed) {
                    input.css('border-color', 'red');
                } else {
                    input.css('border-color', '#BFBFBF');
                }

                if (error.length) {
                    $.each(error, function(index, value) {
                        setNoty(value, 'error');
                    });
                    return 'stop';
                }

                return 'ok';
            }

            $("body").on('click', ".garant-transfers-tabs > ul li", function() {
                var num = $(this).find("label").attr('for'),
                    parent = $(this).closest(".garant-transfers-tabs"),
                    slider = parent.find(".slider");

                parent.find("li span").css({
                    "cursor": "pointer",
                    "color": "#929daf"
                }).attr("data-active", 0);
                $(this).find("span").css({
                    "cursor": "default",
                    "color": "#428BFF"
                }).attr("data-active", 1);

                parent.find('section').hide();
                parent.find("section[data-tab='" + num + "']").show();

                if (parent.attr('data-social') == 'vk') {
                    if (num == 'tab1') {
                        slider.css("transform", "translateX(14%)");
                    } else if (num == 'tab2') {
                        slider.css("transform", "translateX(149%)");
                    } else if (num == 'tab3') {
                        slider.css("transform", "translateX(281%)");
                    }
                } else if (parent.attr('data-social') == 'fb') {
                    if (num == 'tab1') {
                        slider.css("transform", "translateX(48%)");
                    } else if (num == 'tab2') {
                        slider.css("transform", "translateX(248%)");
                    }
                }
            });

            $(window).scroll(function() {
                adjustChatButton('scroll');
            });

            $(document).ready(function() {
                adjustChatButton('load');
            });

            $(window).on('resize', function() {
                adjustChatButton('load');
            });

            $.fn.isInViewport = function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();

                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();

                return elementBottom > viewportTop && elementTop < viewportBottom;
            };

            $("#chat1").on('click', ".open-garants-bar", function() {
                $(this).next().animate({
                    width: 'toggle'
                }, 300);
                $(this).find('img:first-child').toggleClass("rotated");
            });

            function loadMessagesBeforeGarant(el, speed) {
                var garantId = el.attr('data-id'),
                    fromId = $(".friend.group.active").attr('data-from'),
                    msgId = el.attr('data-msg'),
                    dialog = $(".friend.group.active"),
                    container = $(".garant-container[data-id='" + garantId + "']");

                if (fromId) { // admin
                    var toId = dialog.attr('data-to'),
                        chatId = dialog.attr('data-chat_id'),
                        msgFrom = $(".chat__messages[data-from='" + fromId + "'][data-to='" + toId + "'] .simplebar-content > div[msg-id]:first-of-type").attr('msg-id');
                } else {
                    var toId = dialog.attr('data-id'),
                        chatId = null,
                        msgFrom = $(".chat__messages[data-id='" + toId + "'] .simplebar-content > div[msg-id]:first-of-type").attr('msg-id');
                }

                if (container.length) {
                    scrollToGarant(garantId, speed);
                } else {
                    loadMoreMessages(toId, msgFrom, msgId, garantId, fromId, chatId);
                }
            }

            function loadMoreMessages(toId, msgFrom, msgId, garantId, fromId, chatId, scrollTo) {
                loadNewMessages = false;

                var result = '';

                if (fromId) { // admin
                    var chatMessages = $(".chat__messages[data-chat='" + chatId + "']"),
                        url = "/admin/chat/load_more_messages";
                } else {
                    var chatMessages = $(".chat__messages[data-id='" + toId + "']"),
                        url = "/chat/load_more_messages";
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        to: toId,
                        msg_from_id: msgFrom,
                        garant_id: garantId,
                        msg_id: msgId,
                        from: fromId,
                        chat_id: chatId,
                        _token: csrf
                    }
                }).done(function(data) {
                    var messageList = chatMessages.find(".message__list");

                    if (data == 'empty') {
                        messageList.attr('data-fully-loaded', 1);
                        loadNewMessages = true;
                    } else {
                        var wrapper = chatMessages.find(".simplebar-content-wrapper"),
                            content = chatMessages.find(".simplebar-content"),
                            currentHeight = content.height(),
                            currentPosition = wrapper.scrollTop();

                        if (fromId) { // admin
                            drawMessages(data, messageList);
                        } else {
                            drawMessages(data, toId);
                        }

                        var newHeight = content.height();
                        wrapper.scrollTop(newHeight - currentHeight + currentPosition);

                        if (scrollTo) {
                            if (msgId) {
                                scrollTo = content.find("> div[msg-id='" + msgId + "']")
                            } else {
                                scrollTo = $(".garant-container[data-id='" + garantId + "']");
                            }
                            scrollToElementInChat(scrollTo);
                        } else {
                            loadNewMessages = true;
                        }
                    }
                }).fail(function() {
                    loadNewMessages = true;
                });

                return result;
            }

            function showGarantInChat(id, dialog, garantId, preloader, button) {
                if (!dialog) {
                    dialog = $(".friend.group[data-id='" + id + "']");
                }

                $("#chat1").addClass('showed');
                $("body").addClass('chat-open');

                preloader.hide();
                button.show();

                $.when(loadDialog(dialog)).done(function() {
                    loadMessagesToGarantOrMsg(garantId);
                });
            }

            function showMessageInChat(chatId, msgId) {
                var dialog = $(".friend.group[data-chat_id='" + chatId + "']");

                $("#chat1").addClass('showed');
                $("body").addClass('chat-open');

                $.when(loadDialog(dialog, false)).done(function() {
                    loadMessagesToGarantOrMsg(null, msgId);
                });
            }

            function loadMessagesToGarantOrMsg(garantId, msgId, speed) {
                var dialog = $(".friend.group.active"),
                    fromId = dialog.attr('data-from');

                if (fromId) { // admin
                    var toId = dialog.attr('data-to'),
                        chatId = dialog.attr('data-chat_id'),
                        container = $(".chat__messages[data-chat='" + chatId + "'] .simplebar-content");
                } else {
                    var toId = dialog.attr('data-id'),
                        chatId = null,
                        container = $(".chat__messages[data-id='" + toId + "'] .simplebar-content");
                }

                if (msgId) {
                    var scrollTo = container.find("> div[msg-id='" + msgId + "']");
                } else {
                    var scrollTo = $(".garant-container[data-id='" + garantId + "']");
                }

                if (scrollTo.length) {
                    scrollToElementInChat(scrollTo, speed);
                } else {
                    var msgFrom = container.find("> div[msg-id]:first-child").attr('msg-id');
                    loadMoreMessages(toId, msgFrom, msgId, garantId, fromId, chatId, true);
                }
            }

            function scrollToElementInChat(el, speed) {
                if (!speed) speed = 700;
                var cont = $(".message__list:visible .simplebar-content-wrapper");
                var h = cont.height() / 2;
                var elementTop = el.position().top;
                var pos = cont.scrollTop() + elementTop - h;

                cont.stop().animate({
                    scrollTop: pos + 200
                }, speed, function() {
                    loadNewMessages = true;
                });
            }

            function adjustChatButton(type) {
                if ($("footer").isInViewport()) {
                    if (type == 'load') {
                        if ($("body").height() > $(window).height()) {
                            $(".chat-button").css({
                                'position': 'absolute',
                                'bottom': 0
                            });
                        } else {
                            $(".chat-button").closest('section').removeAttr('style');
                            $(".chat-button").css({
                                'position': 'absolute',
                                'bottom': $('footer').height() + 30 + 'px'
                            });
                        }
                    } else {
                        $(".chat-button").closest('section').css('position', 'relative');
                        $(".chat-button").css({
                            'position': 'absolute',
                            'bottom': '-10px'
                        });
                    }
                } else {
                    $(".chat-button").closest('section').css('position', 'relative');
                    $(".chat-button").css({
                        'position': 'fixed',
                        'bottom': '30px'
                    });
                }

                if (type == 'load') {
                    $(".chat-button").css('display', 'block');
                }
            };

            $(document).on('click', ".continue-deal-btn", function() {
                var container = $(this).closest(".garant-container"),
                    buttons = $(this).closest('.deal-action').find(".deal-action__button");

                if (!buttons.length) {
                    buttons = $(this);
                }

                var preloader = $(this).next(),
                    garantId = container.attr('data-id');

                buttons.hide();
                preloader.show();

                $.ajax({
                        url: "/garant/continue",
                        data: {
                            garant_id: garantId,
                            _token: csrf
                        },
                        method: 'POST'
                    })
                    .done(function(text) {
                        buttons.remove();
                        preloader.remove();
                        container.find(".garant-save-wallets-form").remove();
                        container.find(".deal-comment > p").text(text);
                    })
                    .fail(function() {
                        preloader.hide();
                        buttons.show();
                        unknowError();
                    });
            });


            var garantOnlineFrom = new Date('2022-10-18 06:00:00 UTC'),
                garantOnlineTo = new Date('2022-10-18 18:00:00 UTC'),
                garantOnlineFrom = ("0" + garantOnlineFrom.getHours()).slice(-2) + ":00",
                garantOnlineTo = ("0" + garantOnlineTo.getHours()).slice(-2) + ":00";
        </script>
    </footer>