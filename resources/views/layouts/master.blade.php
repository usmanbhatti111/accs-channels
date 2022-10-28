<!DOCTYPE html>
<html lang="en">

<head>

    @include('partials.head')
</head>

<body data-social="youtube" >
    @include('partials.header')
    <main>

        @yield('content')


    </main>
    <section style="position: relative">
        <div id="my-chat-img" style="display: none;">/images/seller.png</div>

        <div id="chat1" class="chat group users-chat-not-admin">
            <div id="mobile-chat-top-panel">
                <table>
                    <tr>
                        <td id="mobile-show-dialogs">Conversation list</td>
                        <td id="mobile-show-profile">Contact</td>
                    </tr>
                </table>
            </div>
            <a href="#" class="chat__close"></a>
            <div class="chat__friends" data-simplebar>
                <img src="images/dialogs_preloader.gif" alt="Loading messages..." id="dialogs-preloader">
            </div>
            <div class="friend group" data-id="admin" data-chat_id="772193">
                <div class="friend__photo">
                    <img src="images/last/hammer_1.png" class="img-responsive img-circle">
                </div>
                <div class="friend__data">
                    <p class="friend__name">Escrow agent</p>
                    <p></p>
                </div>
                <div class="friend__time" msg-id="1"></div>
                <span class="friend__noty">0</span>
            </div>
            <div id="dialog-preloader">
                <img src="images/chat_preloader.gif" alt="Loading...">
            </div>
        </div>
        <div class="chat-button">
            <a href="#"></a>
            <span style="display: none;">0</span>
            <img class="dialog-alarm-bell" id="all-chat-alarm-bell" style="" src="images/alarm-bell-symbol.png">
        </div>

        <audio id="chat-audio" src="sounds/noty.wav"></audio>


        <script src="js/countdown-timer.min.js"></script>
        <script>
            function drawMessages(data, toId) {
                var html_messages = '',
                    myImage = $("#my-chat-img").text(),
                    messageList = $(".chat__messages[data-id='" + toId + "'] .message__list"),
                    admins = data.admins,
                    allUploads = data.uploads;

                if (data.end) {
                    messageList.attr('data-fully-loaded', 1);
                }

                if (toId != 'admin') {
                    var garantEvents = data.garant_events,
                        adminNoty = data.admin_noty,
                        timersList = [],
                        expireTimersList = [],
                        instData = data.inst_infos,
                        adminLinks = data.admin_links,
                        adminTransfers = data.admin_transfers,
                        dealPaymentMethods = data.deal_payment_methods,
                        waitDecisions = data.wait_decisions,
                        paymentMethods = data.payment_methods,
                        youtubeAccounts = data.youtube_accounts,
                        garantReviews = data.garant_reviews,
                        userReviews = data.user_reviews,
                        returnAccountInCancelledDeals = data.return_account_in_cancelled_deals;
                }

                $.each(data.messages, function(index, value) {
                    var mine = '',
                        thisMessage = value,
                        msgId = value.id,
                        admin = null,
                        uploads = allUploads[msgId],
                        myId = 1490768728;

                    if (toId != 'admin' && data.user) {
                        var cImage = data.user.img_path,
                            image = 'images/seller.png',
                            actionsReview = false;
                    }

                    if (!value.admin) {
                        if (value.to == myId) {
                            mine = 'mine';
                            if (cImage != null)
                                image = cImage;
                        } else {
                            image = myImage;
                        }
                    } else {
                        image = 'images/friend3.png';
                        mine = 'system';
                    }

                    if (!image) {
                        image = 'images/seller.png';
                    }

                    if (value.msg || uploads) {
                        if (value.admin && value.admin !== 1)
                            admin = admins[value.admin];

                        var readAttr = value.user_read
                        if (mine == 'system' && value.from == myId) {
                            readAttr = value.user_from_read;
                        }

                        var uploadsHtml = drawChatUploads(uploads);

                        html_messages +=
                            "<div " + (!mine ? "data-sent='1' data-read='" + value.user_read + "' data-admin-sent='" + value.admin_sent + "' data-admin-read='" + value.admin_read + "'" : "data-read='" + readAttr + "'") + " class='message " + mine + " group " + (uploadsHtml.filesCount ? "media" : "") + "' msg-id='" + msgId + "'>" +
                            "<div class='message__photo'>" +
                            "<img src='" + image + "' class='img-responsive img-circle'>" +
                            (!mine ? readIcons() : "") +
                            "<time datetime data-time='" + value.timestamp + "'>" + value.created_at_human + "</time>" +
                            "</div>" +
                            "<div class='message__text'>" +
                            "<div class='inner " + uploadsHtml.mediaQuantity + "' " + (admin ? "style='border: 2px solid " + admin.color + ";'" : "") + ">" + value.msg + uploadsHtml.mediaFiles +
                            "<div class='mobile-container'>" +
                            (!mine ? readIcons() : "") +
                            "<span class='mobile-msg-time'>" + value.created_at_human + "</span>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";
                    }

                    if (toId != 'admin') {
                        $.each(data.garants, function(index, value) {
                            if (value.message_id == msgId) {
                                var comment = '',
                                    adminInstInfos = '',
                                    instInfos = '',
                                    actionsDiv = '',
                                    infoInput = '',
                                    selectCond = '',
                                    actionsComment = '',
                                    thisGarantEvent = garantEvents[value.id],
                                    garantId = value.id,
                                    dealRules = '';

                                if (value.social == 'in' || value.social == 'twitter') {
                                    dealRules =
                                        "<ol>" +
                                        "<li>The buyer pays a 7% ($3 minimum) service fee.</li>" +
                                        "<li>The seller transfers login details and the original email account to the escrow agent.</li>" +
                                        "<li>The escrow agent checks everything, changes the login details, and tells the buyer to pay the seller.</li>" +
                                        "<li>The buyer pays the seller.</li>" +
                                        "<li>After the seller’s confirmation, the system sends the new login details to the buyer.</li>" +
                                        "</ol>";
                                } else if (value.social == 'fb') {
                                    dealRules =
                                        "<ol>" +
                                        "<li>The buyer pays a 7% ($3 minimum) service fee.</li>" +
                                        "<li>The seller assigns the escrow agent’s page as the administrator.</li>" +
                                        "<li>The escrow agent checks everything, removes the other administrators, and tells the buyer to pay the seller.</li>" +
                                        "<li>The buyer pays the seller.</li>" +
                                        "<li>After the seller’s confirmation, the escrow agent assigns the buyer’s page as the administrator.</li>" +
                                        "</ol>";
                                } else if (value.social == 'tg') {
                                    dealRules =
                                        "<ol>" +
                                        "<li>The buyer pays a 7% ($3 minimum) service fee.</li>" +
                                        "<li>The seller sends the account creator’s phone number to the escrow agent.</li>" +
                                        "<li>In order to login, the escrow agent asks for a verification code that is sent to the account creator’s phone number.</li>" +
                                        "<li>The escrow agent then connects their phone number and tells the buyer to pay the seller.</li>" +
                                        "<li>The buyer pays the seller.</li>" +
                                        "<li>After the seller’s confirmation, the escrow agent connects the buyer’s phone number.</li>" +
                                        "</ol>";
                                } else if (value.social == 'youtube') {
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

                                if (value.status_from == 1 && value.status_to == 0) {
                                    comment = "Waiting for seller to agree to the terms of the transaction.";

                                    if (thisMessage.to == myId) {
                                        var dealPaymentMethod = dealPaymentMethods[value.id];

                                        actionsDiv = "";

                                        if (dealPaymentMethod) {
                                            actionsDiv +=
                                                "<div class='chat-payment-methods'>" +
                                                "<p>Payment methods chosen by the buyer. If you can accept one of them, agree to the deal. If none of them suit you, try to negotiate something else with him, and then agree.</p>" +
                                                "<ul>";

                                            $.each(dealPaymentMethod, function() {
                                                var paymentMethod = paymentMethods[this.payment_method_id];

                                                if (paymentMethod)
                                                    actionsDiv += "<li data-id='" + paymentMethod.id + "'><img src='" + paymentMethod.img + "' alt='" + paymentMethod.name + "'></li>";
                                            });

                                            actionsDiv += "</ul></div>";
                                        }

                                        actionsDiv +=
                                            "<div class='deal-action group'>" +
                                            "<div class='deal-action__button accept-condition-btn'>" +
                                            "<a href='#' class='orange' data-who='seller'>I agree with the terms of the transaction</a>" +
                                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                            "</div>" +
                                            "</div>";
                                    }
                                } else if (value.status_from == 0 && value.status_to == 1) {
                                    comment = "Waiting for the buyer to agree to the terms of the transaction.";
                                    var infoField = "";

                                    if (thisMessage.from == myId && value.social != 'in' && value.social != 'twitter') {
                                        infoField =
                                            "<input class='transfer-info-input' style='width: " + (value.social == 'youtube' ? 380 : (value.social == 'tg' ? 329 : 271)) + "px;' data-first='" + value.transfer + "' data-info='" + (value.info ? value.info : "") + "' data-transfer='" + value.transfer + "' type='text' name='info' value='" + (value.info ? value.info : "") + "' placeholder='" + (value.social == 'youtube' ? 'Email address of the account to transfer ownership rights to' : (value.social == 'fb' ? "Link to the page for transfer of ownership" : "Phone number to associate with Telegram account")) + "'>";
                                    }

                                    if (thisMessage.from == myId) {
                                        actionsDiv =
                                            infoField +
                                            "<div class='deal-action group'>" +
                                            "<div class='deal-action__button accept-condition-btn'>" +
                                            "<a href='#' class='orange' data-who='buyer'>I agree with the terms of the transaction</a>" +
                                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                            "</div>" +
                                            "</div>";
                                    }
                                } else if (value.status_from == 1 && value.status_to == 1) {
                                    if (thisMessage.from == myId) {
                                        comment = "The terms of the transaction were confirmed. When you send your payment, the seller will be notified, and will need to transfer the account login details based on the agreed upon terms. If the seller does not respond, or breaks the rules, you can call upon the escrow agent (button below).";
                                        actionsDiv = drawChatPaymentMethods(value.amount, data.discount, 'buyer');
                                    } else {
                                        comment = "The terms of the transaction were confirmed, awaiting payment. Do not transfer the account directly! Follow the instructions on this page once the buyer has paid.";
                                        actionsDiv = drawChatPaymentMethods(value.amount, data.discount, 'seller');
                                    }
                                } else if (value.status_from == 2 && value.status_to == 1) {
                                    if (thisMessage.from == myId) {
                                        if (value.social == 'fb') {
                                            comment = "You’ve paid, and we’ve notified the seller. Waiting for them to transfer administrative rights to the escrow agent. As soon as they’ve been transferred and the escrow agent has confirmed everything, we will notify you so that you can pay the seller.";
                                        } else if (value.social == 'in' || value.social == 'twitter') {
                                            comment = "You’ve paid, and we’ve notified the seller. Waiting for them to transfer login details to the escrow agent. As soon as they transfer them and the escrow agent has verified everything, we will notify you so that you can transfer payment to the seller.";
                                        } else if (value.social == 'tg') {
                                            comment = "You’ve paid, and we’ve notified the seller. We’re waiting for the seller to send the escrow agent the phone number associated with the creator’s account.";
                                        } else if (value.social == 'youtube') {
                                            comment = "You’ve paid, and we’ve notified the seller. We’re waiting for the seller to assign the escrow agent as a manager.";
                                        } else if (value.social == 'tg') {
                                            comment = "You’ve paid, and we’ve notified the seller. We’re waiting for the seller to transfer to the escrow agent the phone number for entry into the account.";
                                        }

                                        comment += " The seller has <span class='garant-timer-expire' id='countdown" + value.id + "'></span> left to do this, after which we will offer you a refund.";

                                        if (value.social != 'in' && value.social != 'twitter') {
                                            infoInput =
                                                "<input type='text' class='form-control' style='width: 100%;' value='" + value.info + "' readonly>";
                                        }
                                    } else {
                                        if (value.social == 'fb') {
                                            comment = "The buyer has paid the escrow agent's commission. Now, you need to assign the escrow agent’s page as the administrator (shown below), and then leave the group/page. After this, our moderator will verify everything, and notify the buyer to pay you.";

                                            var adminLink = '';

                                            $.each(adminTransfers, function(index, value) {
                                                if (value.garant_id == garantId) {
                                                    adminLink = adminLinks.fb[value.admin_id];
                                                    return false;
                                                }
                                            });

                                            if (!adminLink) {
                                                adminLink = adminLinks.fb.main_link;
                                            }

                                            infoInput =
                                                "<input type='text' class='form-control' style='width: 100%;' value='" + adminLink + "' readonly>";
                                        } else if (value.social == 'in' || value.social == 'twitter') {
                                            comment = "The buyer has paid. Now, you need to fill in the field below with the login details for your account, as well as for the original email associated with the account." + (value.social == 'in' ? " <b>Make sure to first disconnect your Instagram account from your Facebook account (if they’re linked together).</b>" : "") + " After this, our moderator will verify the account details and notify the buyer for them to pay you.";

                                            actionsComment =
                                                "<div class='deal-actions'>" +
                                                "<div class='deal-comment'>" +
                                                "<textarea class='instagram-infos' name='instagram-infos' placeholder='Enter the details we’ve asked for here.'></textarea>" +
                                                "</div>" +
                                                "</div>";
                                        } else if (value.social == 'tg') {
                                            comment = "The buyer has paid, now you need to fill in the field below with the phone number associated with the creator’s account. The escrow agent will log into your account and associate their own phone number with it, after which they will notify the buyer for them to pay you. In order to log in, the escrow agent will ask you for the verification code that you will receive to your phone. The escrow agent is online from " + garantOnlineFrom + " to " + garantOnlineTo + ". Please make sure to be online during this time to tell the escrow agent the verification code.";
                                            actionsComment =
                                                "<div class='deal-actions'>" +
                                                "<div class='deal-comment'>" +
                                                "<textarea class='instagram-infos' name='instagram-infos' placeholder='Please enter the phone number for entry into the account here.'></textarea>" +
                                                "</div>" +
                                                "</div>";
                                        } else if (value.social == 'youtube') {
                                            var youtubeEmail = youtubeAccounts[value.id];

                                            comment = "The buyer has paid. Now, you need to assign the escrow agent’s account as a manager. The escrow agent’s email is indicated below. If you don’t have a button for transferring administrative rights, that means you have not yet linked the channel with the brand’s account. Follow <a target='_blank' href='https://support.google.com/youtube/answer/3056283'>these instructions</a> in order to link your account.";

                                            infoInput =
                                                "<input type='text' class='form-control' style='width: 100%;' value='" + youtubeEmail + "' readonly>";

                                            // infoInput =
                                            //     "<div class='youtube-transfer-manager-info'>" +
                                            //     "<b>Escrow agent</b>" +
                                            //     "<input type='text' class='form-control' style='width: 100%;' value='"+ youtubeEmail +" (manager)' readonly>" +
                                            //     "<b>Buyer</b>" +
                                            //     "<input type='text' class='form-control' style='width: 100%;' value='"+ value.info +" (communications manager)' readonly>" +
                                            //     "</div>";
                                        }

                                        comment += " You have <span class='garant-timer-expire' id='countdown" + value.id + "'></span> to do this, after which we will offer the buyer a refund.";

                                        var btnText = null;

                                        if (value.social == 'in' || value.social == 'twitter' || value.social == 'tg') {
                                            btnText = "Submit data for review";
                                        } else if (value.social == 'youtube') {
                                            btnText = "Assigned the escrow agent as manager";
                                        } else if (value.social == 'fb') {
                                            btnText = "Assigned the escrow agent administrative rights";
                                        }

                                        actionsDiv =
                                            "<div class='deal-actions'>" +
                                            "<div class='deal-action group'>" +
                                            "<div class='deal-action__button garant-transferred-btn'>" +
                                            "<a href='#' class='orange'>" + btnText + "</a>" +
                                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                            "</div>" +
                                            (value.social == 'fb' ? "<p class='not-joined-p'>If this page isn’t a member of the group, contact the escrow agent and ask them to join.</p>" : '') +
                                            "</div>" +
                                            "</div>";
                                    }
                                } else if (value.status_from == 2 && value.status_to == 2) {
                                    if (thisMessage.from == myId) {
                                        if (value.social == 'fb') {
                                            comment = "The seller has transferred administrative rights to the escrow agent. The escrow agent will verify this and notify you soon, so that you can pay the seller.";
                                            infoInput =
                                                "<input type='text' class='form-control' style='width: 100%;' value='" + value.info + "' readonly>";
                                        } else if (value.social == 'in' || value.social == 'twitter') {
                                            comment = "The seller has transferred the account as well as the associated email to the escrow agent. The escrow agent will verify this soon, and then change the password on the account and on the associated original email. When this is done, they will notify you so that you can pay the seller.";
                                        } else if (value.social == 'tg') {
                                            comment = "The seller has given the phone number to the escrow agent. The escrow agent will request a verification code soon, in order to login to the account and verify everything. Once everything is verified, they will associate their own phone number with the account and notify you so that you can pay the seller.";
                                        } else if (value.social == 'youtube') {
                                            comment = "The seller has designated the escrow agent's account as the channel's manager. The escrow agent will now verify this and begin the 7 days timer, after which the seller will designate the escrow agent as the primary owner (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel).";
                                        }
                                    } else if (thisMessage.to == myId) {
                                        if (value.social == 'fb') {
                                            comment = "You’ve transferred administrative rights to the escrow agent. They will verify this soon and notify the buyer, for them to pay you.";
                                        } else if (value.social == 'in' || value.social == 'twitter') {
                                            comment = "You’ve sent the requested details to the escrow agent. They will verify everything soon, change the password on the account and on the associated original email, and then notify the buyer for them to pay you.";
                                        } else if (value.social == 'youtube') {
                                            comment = "You've designated the escrow agent as the channel's manager. They will now verify this and begin the 7 days timer, after which you need to transfer primary ownership rights to them (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel).";
                                        } else if (value.social == 'tg') {
                                            comment = "You’ve sent the phone number associated with the account to the escrow agent. The escrow agent is online between " + garantOnlineFrom + " to " + garantOnlineTo + ". Please make sure to be online during this time, so that you can give them the verification code sent to your phone.";
                                        }
                                    }
                                } else if (value.status_from == 2 && value.status_to == 12) {
                                    if (value.social == 'youtube') {
                                        var waitDecision = waitDecisions[value.id],
                                            waitTime = 21 - waitDecision.from_creation,
                                            btnTxt = "",
                                            btnDisabled = "";

                                        comment = "The escrow agent has become a manager. ";

                                        if (thisMessage.from == myId) {
                                            comment += "We suggest you wait " + waitTime + " " + getDayStr(waitTime) + " in case the channel is stolen. In most cases, if the channel is indeed stolen, its true owner restores it within 3 weeks." + (waitDecision.from_creation ? " Since the listing was created " + (waitDecision.from_creation) + " " + getDayStr(waitDecision.from_creation) + " ago, it remains to wait only " + waitTime + " " + getDayStr(waitTime) + "." : "");

                                            if (waitDecision.seller == 1) {
                                                btnTxt = " (seller agreed)";
                                            } else if (waitDecision.seller == 2 || waitDecision.buyer == 1) {
                                                if (waitDecision.buyer == 1) {
                                                    btnTxt = " (waiting for the seller's agreement)";
                                                } else {
                                                    btnTxt = " (seller refused)";
                                                }

                                                btnDisabled = " link-disabled";
                                            }

                                            actionsDiv =
                                                "<div class='deal-actions admin_transfer-decision-action'>" +
                                                "<div class='deal-action group'>" +
                                                "<div class='deal-action__button accept-decision-btn'>" +
                                                "<a href='#' class='orange" + btnDisabled + "' data-decision='1'>I agree to wait " + waitTime + " " + getDayStr(waitTime) + btnTxt + "</a>" +
                                                "</div>" +
                                                "<div class='deal-action__button accept-decision-btn'>" +
                                                "<a href='#' class='risk-btn' data-decision='2' data-warning='1'>I agree without waiting (only 7 days)</a>" +
                                                "</div>" +
                                                "<div " + (waitDecision.seller != 2 ? "style='display: none;'" : "") + " class='deal-action__button decline-decision-btn'>" +
                                                "<a href='#' class='violet'>Return payment (cancel the transaction)</a>" +
                                                "</div>" +
                                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                                "</div>" +
                                                "</div>";

                                        } else {
                                            comment += "We suggested the buyer wait " + waitTime + " " + getDayStr(waitTime) + " in case the channel is stolen. In most cases, if the channel is indeed stolen, its true owner restores it within 3 weeks." + (waitDecision.from_creation ? " Since the listing was created " + (waitDecision.from_creation) + " " + getDayStr(waitDecision.from_creation) + " ago, it remains to wait only " + waitTime + " " + getDayStr(waitTime) + "." : "") + " The buyer also has the opportunity to continue the transaction without waiting at his own risk.";

                                            var waitBtnTxt = " (also agree to continue immediately)",
                                                waitBtnDisabled = "";

                                            if (waitDecision.buyer == 1) {
                                                btnTxt = " (buyer refused)";
                                                waitBtnTxt = "";
                                                btnDisabled = " link-disabled";
                                            } else if (waitDecision.seller == 1) {
                                                waitBtnTxt = " (waiting for the buyer's agreement)";
                                                waitBtnDisabled = " link-disabled";
                                            } else if (waitDecision.seller == 2) {
                                                btnTxt = " (waiting for the buyer's agreement)";
                                                btnDisabled = " link-disabled";
                                            }

                                            actionsDiv =
                                                "<div class='deal-actions admin_transfer-decision-action'>" +
                                                "<div class='deal-action group'>" +
                                                "<div class='deal-action__button accept-decision-btn'>" +
                                                "<a href='#' class='orange" + waitBtnDisabled + "' data-decision='1'>I agree to wait " + waitTime + " " + getDayStr(waitTime) + waitBtnTxt + "</a>" +
                                                "</div>" +
                                                "<div class='deal-action__button accept-decision-btn'>" +
                                                "<a href='#' class='risk-btn" + btnDisabled + "' data-decision='2'>I agree only without waiting" + btnTxt + "</a>" +
                                                "</div>" +
                                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                                "</div>" +
                                                "</div>";
                                        }
                                    }
                                } else if (value.status_from == 2 && value.status_to == 13) {
                                    if (value.social == 'youtube') {
                                        var waitDecision = waitDecisions[value.id],
                                            waitTime = 21 - waitDecision.from_creation;

                                        comment = "We are waiting for " + waitTime + " " + getDayStr(waitTime) + " to make sure that the channel will not be restored. After this period ";

                                        if (thisMessage.from == myId) {
                                            comment += "the seller will have to transfer primary ownership rights.";
                                        } else {
                                            comment += "you will have to transfer primary ownership rights.";
                                        }

                                        instInfos =
                                            "<div class='garant-timer-block'>" +
                                            "<b>Until the end of the hold:</b>" +
                                            "<div class='garant-timer' id='countdown" + value.id + "'></div>" +
                                            "</div>";

                                        var transferredAt = value.transferred_at,
                                            myDate = new Date(),
                                            setSeconds = Math.round(transferredAt + waitTime * 24 * 3600 - 1666109827);

                                        myDate.setSeconds(setSeconds);
                                        timersList.push([".garant-timer#countdown" + value.id, myDate, 'youtube_waiting']);
                                    }
                                } else if (value.status_from == 2 && value.status_to == 8) {
                                    if (thisMessage.from == myId) {
                                        if (value.social == 'youtube') {
                                            comment = "The escrow agent has become a manager. In 7 days the seller will be able to transfer primary ownership rights to them (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel).";
                                        }
                                    } else {
                                        if (value.social == 'youtube') {
                                            comment = "The escrow agent has become a manager. In 7 days you need to transfer primary ownership rights to them (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel).";
                                        }
                                    }

                                    var myDate = new Date(),
                                        unix = 1666109827;

                                    setSeconds = Math.round(value.transferred_at + 7 * 24 * 3600 - unix);

                                    instInfos =
                                        "<div class='garant-timer-block'>" +
                                        "<b>Primary ownership rights can be transferred in:</b>" +
                                        "<div class='garant-timer' id='countdown" + value.id + "'></div>" +
                                        "</div>";

                                    myDate.setSeconds(setSeconds);
                                    timersList.push([".garant-timer#countdown" + value.id, myDate, 'youtube_waiting']);
                                } else if (value.status_from == 2 && value.status_to == 9) {
                                    if (thisMessage.from == myId) {
                                        if (value.social == 'youtube') {
                                            comment = "7 days have passed. Now the seller needs to transfer primary ownership rights. The seller has <span class='garant-timer-expire' id='countdown" + value.id + "'></span> left to do this, after which we will offer you a refund.";
                                        }
                                    } else {
                                        if (value.social == 'youtube') {
                                            comment = "7 days have passed. Now you need to transfer primary ownership rights to the escrow agent. You have <span class='garant-timer-expire' id='countdown" + value.id + "'></span> to do this, after which we will offer the buyer a refund.";

                                            actionsDiv =
                                                "<div class='deal-actions'>" +
                                                "<div class='deal-action group'>" +
                                                "<div class='deal-action__button garant-transferred-btn'>" +
                                                "<a href='#' class='orange'>Transferred primary ownership rights</a>" +
                                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                                "</div>" +
                                                "</div>" +
                                                "</div>";
                                        }
                                    }
                                } else if (value.status_from == 2 && value.status_to == 11) {
                                    if (thisMessage.from == myId) {
                                        if (value.social == 'youtube') {
                                            comment = "The seller has transferred primary ownership rights to the escrow agent. The escrow agent will now verify this, and remove all the other managers. They will then notify you to pay the seller.";
                                        }
                                    } else {
                                        if (value.social == 'youtube') {
                                            comment = "You’ve transferred primary ownership rights to the escrow agent. They will verify this soon and notify the buyer, for them to pay you.";
                                        }
                                    }
                                } else if (value.status_from == 2 && value.status_to == 10) {
                                    if (thisMessage.from == myId) {
                                        if (value.social == 'in' || value.social == 'twitter') {
                                            comment = "The escrow agent has obtained access to the account and changed the login details so that the seller cannot regain access. Now, you need to pay the seller. If they have not yet given you their payment details, please ask them. After the seller has confirmed that they’ve received the payment, the escrow agent will send you the account details. <b>When you transfer money via Paypal, you must choose the method of sending to a friend. If you choose to pay as for goods or services, you will have the opportunity to refund your payment after the end of the transaction when you already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. The seller will receive the same message so he can double-check on his side if you've sent him the payment correctly.</b>";
                                        } else if (value.social == 'youtube') {
                                            comment = "The escrow agent has become the primary owner and has removed all the other managers. Now, you need to pay the seller. If they have not yet given you their payment details, please ask them. After the seller has confirmed that they’ve received the payment, the escrow agent will designate you as the channel’s owner. <b>When you transfer money via Paypal, you must choose the method of sending to a friend. If you choose to pay as for goods or services, you will have the opportunity to refund your payment after the end of the transaction when you already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. The seller will receive the same message so he can double-check on his side if you've sent him the payment correctly.</b>";
                                        } else if (value.social == 'fb') {
                                            comment = "The escrow agent has received administrative rights and verified that the seller has removed themselves from the list of administrators. Now, you need to pay the seller. If they have not yet given you their payment details, please ask them. After the seller has confirmed that they’ve received the payment, the escrow agent will transfer administrative rights to you. <b>When you transfer money via Paypal, you must choose the method of sending to a friend. If you choose to pay as for goods or services, you will have the opportunity to refund your payment after the end of the transaction when you already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. The seller will receive the same message so he can double-check on his side if you've sent him the payment correctly.</b>";
                                        } else if (value.social == 'tg') {
                                            comment = "The escrow agent has received access to the creator’s account and changed their phone number, so that the seller cannot restore access to the account. Now, you need to pay the seller. If they have not yet given you their payment details, please ask them. After the seller has confirmed that they’ve received the payment, the escrow agent will associate your phone number with the account. <b>When you transfer money via Paypal, you must choose the method of sending to a friend. If you choose to pay as for goods or services, you will have the opportunity to refund your payment after the end of the transaction when you already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. The seller will receive the same message so he can double-check on his side if you've sent him the payment correctly.</b>";
                                        }

                                        actionsDiv =
                                            "<div class='deal-actions'>" +
                                            "<div class='deal-action group'>" +
                                            "<div class='deal-action__button money-sent-to-seller-btn' style='margin-left: 0;'>" +
                                            "<a href='#' class='orange'>Paid the seller</a>" +
                                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                            "</div>" +
                                            "</div>" +
                                            "</div>";
                                    } else {
                                        comment = "The escrow agent has received access to the account. Now the buyer needs to pay you. Give them your payment details. <b>If the buyer pays you via PayPal, you must make sure that they sent you the money as a transfer to a friend, and not as a payment for items or services. In this case buyer will have the opportunity to refund the payment after the end of the transaction, when they already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. To make sure that the transfer is correct, you must open the PayPal transaction and check that the address for sending the goods was not indicated there. If the address is indicated, you must return the money back to buyer and ask them to pay you as specified in this message.</b>";
                                    }
                                } else if (value.status_from == 2 && value.status_to == 4) {
                                    if (thisMessage.from == myId) {
                                        var text = null;

                                        if (value.social == 'in' || value.social == 'twitter') {
                                            text = "the system automatically issues you new details for your account";
                                        } else if (value.social == 'youtube') {
                                            text = "the escrow agent designates you as the channel owner";
                                        } else if (value.social == 'fb') {
                                            text = "the escrow agent will transfer administrative rights to you";
                                        } else if (value.social == 'tg') {
                                            text = "the escrow agent will associate your phone number with the account";
                                        }

                                        comment = "You’ve sent payment to the seller. After the seller’s confirmation, " + text + ". If the seller takes too long to confirm receipt of payment, get in touch with the escrow agent.";
                                    } else {
                                        comment = "The buyer has paid you. After you’ve received payment, please click the confirmation button so that the escrow agent can transfer account access to the buyer.";

                                        actionsDiv =
                                            "<div class='deal-actions'>" +
                                            "<div class='deal-action group'>" +
                                            "<div class='deal-action__button group-received-btn' style='margin-left: 0;'>" +
                                            "<a href='#' class='orange'>Received payment, transfer account access to the buyer</a>" +
                                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                            "</div>" +
                                            "</div>" +
                                            "</div>";
                                    }
                                } else if (value.status_from == 2 && value.status_to == 6) {
                                    if (value.social == 'youtube') {
                                        if (thisMessage.from == myId) {
                                            comment = "The seller has confirmed receipt of payment. The escrow agent will designate your account as owner soon.";
                                        } else {
                                            comment = 'You’ve confirmed receipt of payment. The escrow agent will designate the buyer’s account as owner soon.';
                                        }
                                    } else if (value.social == 'fb') {
                                        if (thisMessage.from == myId) {
                                            comment = "The seller has confirmed receipt of payment. The escrow agent will transfer administrative rights to you soon.";
                                        } else {
                                            comment = 'You’ve confirmed receipt of payment. The escrow agent will transfer administrative rights to the buyer soon.';
                                        }
                                    } else if (value.social == 'tg') {
                                        if (thisMessage.from == myId) {
                                            comment = "The seller has confirmed receipt of payment. The escrow agent will associate your phone number with the account soon.";
                                        } else {
                                            comment = 'You’ve confirmed receipt of payment. The escrow agent will associate the buyer’s phone number with the account soon.';
                                        }
                                    }
                                } else if (value.status_from == 2 && value.status_to == 7) {
                                    if (value.social == 'youtube') {
                                        if (thisMessage.from == myId) {
                                            comment = "Transaction completed successfully! The escrow agent has assigned your account as owner. You must <a href='https://myaccount.google.com/u/0/brandaccounts?si=1' target='_blank'>accept the invitation</a>. In 7 days they will be able to designate you as the primary owner or you can do that by yourself (7 days is the minimum amount of waiting time required in order to assign a new person as the primary owner in the control panel).";
                                        } else {
                                            comment = "Transaction completed successfully! The escrow agent has assigned the buyer as owner. In 7 days they will be able to designate them as the primary owner or the buyer can do that by himself (7 days is the minimum amount of waiting time required in order to assign a new person as the primary owner in the control panel).";
                                        }

                                        actionsComment = drawReviewForms(thisMessage.from == myId ? 'buyer' : 'seller', garantId, garantReviews[value.id], userReviews[value.id]);
                                        actionsReview = true;

                                        instInfos =
                                            "<div class='garant-timer-block'>" +
                                            "<b>Primary ownership rights can be transferred in:</b>" +
                                            "<div class='garant-timer' id='countdown" + value.id + "'></div>" +
                                            "</div>";

                                        var transferredAt = value.transferred_at,
                                            myDate = new Date(),
                                            setSeconds = Math.round(transferredAt + 7 * 24 * 3600 - 1666109827);

                                        myDate.setSeconds(setSeconds);
                                        timersList.push([".garant-timer#countdown" + value.id, myDate, 'youtube_waiting']);
                                    }
                                } else if (value.status_from == 3 && value.status_to == 3) {
                                    if (thisMessage.from == myId) {
                                        comment = "The transaction has been completed successfully! We would be grateful if you could leave a review about your experience.";

                                        if (value.social == 'in' || value.social == 'twitter') {
                                            var socialData = value.social == 'in' ? "Instagram" : 'Twitter';

                                            $.each(instData, function(index, value) {
                                                if (value.garant_id == garantId) {
                                                    instInfos =
                                                        "<div class='inst-infos-buyed'>" +
                                                        "<b>" + socialData + ":</b>" +
                                                        "<p>Username: " + value.login + "</p>" +
                                                        "<p>Password: " + value.pass + "</p>" +
                                                        "<b>Email:</b>" +
                                                        "<p>Address: " + value.email + "</p>" +
                                                        "<p>Password: " + value.email_pass + "</p>" +
                                                        "</div>";

                                                    return false;
                                                }
                                            });
                                        } else if (value.social == 'tg') {
                                            instInfos =
                                                "<div class='inst-infos-buyed'>" +
                                                "<b>The creator’s account:</b>" +
                                                "<p>Your phone number: <i>" + value.info + "</i></p>" +
                                                "</div>";
                                        }
                                    } else {
                                        comment = "The transaction has been completed successfully! Details about the account have been sent to the buyer. We would be grateful if you could leave a review about your experience.";
                                    }

                                    actionsComment = drawReviewForms(thisMessage.from == myId ? 'buyer' : 'seller', garantId, garantReviews[value.id], userReviews[value.id]);

                                    actionsReview = true;
                                } else if (value.status_to == 5) {
                                    var text = "The transaction has been cancelled";

                                    if (value.status_from == 4) {
                                        if (thisMessage.from == myId) {
                                            comment = text + ". Please confirm that you haven’t yet paid the seller, so that they don’t have to wait for the timer to have their account returned to them. If you have already paid them, please immediately click this button, or in <span class='garant-timer-expire' id='countdown" + value.id + "'></span> the seller will automatically have their account returned to them. After the transaction’s cancellation, your payment will be refunded to your balance.";

                                            actionsDiv =
                                                "<div class='deal-actions'>" +
                                                "<div class='deal-action group'>" +
                                                "<div class='deal-action__button confirm-cancel-btn'>" +
                                                "<a href='#' class='orange'>Payment has not yet been sent. Return the account to the seller</a>" +
                                                "</div>" +
                                                "<div class='deal-action__button continue-deal-btn'>" +
                                                "<a href='#' class='orange risk-btn'>Payment has already been sent, do not cancel the transaction!</a>" +
                                                "</div>" +
                                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                                "</div>" +
                                                "</div>";
                                        } else {
                                            var cancelledInfo = data.cancelled_infos[value.id];

                                            comment = text + ". The buyer has <span class='garant-timer-expire' id='countdown" + value.id + "'></span> to confirm that they have not yet paid you. After this time, you will automatically have your account returned to you.";

                                            if (cancelledInfo && cancelledInfo.cancelled_by == 'seller') {
                                                actionsComment +=
                                                    "<button class='orange continue-deal-btn continue-deal-btn-seller'>Continue with the transaction</button>" +
                                                    "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Waiting...'>";
                                            }
                                        }
                                    } else {
                                        var returnAccountInCancelledDeal = returnAccountInCancelledDeals[value.id];

                                        if (value.status_from == 5) {
                                            if (thisMessage.from == myId) {
                                                comment = text + ", and payment has been refunded to your balance.";
                                            } else {
                                                comment = text + ", and payment has been refunded to the buyer. ";
                                            }
                                        } else if (value.status_from == 6) {
                                            comment = text + ", waiting for the wallet from the buyer to make a refund. ";

                                            if (thisMessage.from == myId) {
                                                actionsDiv +=
                                                    "<form class='group garant-save-wallets-form'>" +
                                                    "<p>Bitcoin wallet to get a refund:</p>" +
                                                    "<input class='form-control' type='text' placeholder='Your BTC address'>" +
                                                    "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                                    "<button type='submit'>Get a refund</button>" +
                                                    "</form>";
                                            }
                                        }

                                        if (thisMessage.to == myId && returnAccountInCancelledDeal) {
                                            if (value.social == 'in' || value.social == 'twitter') {
                                                comment += "Your new account details are shown below.";

                                                var socialData = value.social == 'in' ? "Instagram" : 'Twitter';

                                                $.each(instData, function(index, value) {
                                                    if (value.garant_id == garantId) {
                                                        instInfos =
                                                            "<div class='inst-infos-buyed'>" +
                                                            "<b>" + socialData + ":</b>" +
                                                            "<p>Username: " + value.login + "</p>" +
                                                            "<p>Password: " + value.pass + "</p>" +
                                                            "<b>Email:</b>" +
                                                            "<p>Address: " + value.email + "</p>" +
                                                            "<p>Password: " + value.email_pass + "</p>" +
                                                            "</div>";

                                                        return false;
                                                    }
                                                });
                                            } else {
                                                if (returnAccountInCancelledDeal.status == 0) {
                                                    if (value.social == 'tg') {
                                                        comment += "Please provide the phone number you would like to restore the account to.";
                                                    } else if (value.social == 'youtube') {
                                                        comment += "Please provide the email address of the account to which you’d like to restore ownership rights.";
                                                    } else if (value.social == 'fb') {
                                                        comment += "Please provide a link to the page to which you would like to restore administrative rights.";
                                                    }

                                                    actionsComment =
                                                        "<div class='deal-actions'>" +
                                                        "<div class='deal-comment'>" +
                                                        "<textarea class='instagram-infos' name='instagram-infos' placeholder='Please enter the aforementioned details here'></textarea>" +
                                                        "</div>" +
                                                        "</div>";

                                                    actionsDiv =
                                                        "<div class='deal-actions'>" +
                                                        "<div class='deal-action group'>" +
                                                        "<div class='deal-action__button send-info-to-return-account' style='margin-left: 0'>" +
                                                        "<a href='#' class='orange'>Send</a>" +
                                                        "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                                        "</div>" +
                                                        "</div>" +
                                                        "</div>";
                                                } else if (returnAccountInCancelledDeal.status == 1) {
                                                    if (value.social == 'tg') {
                                                        comment += "You’ve given the escrow agent the phone number with which to associate the account. The escrow agent is online from " + garantOnlineFrom + " to " + garantOnlineTo + ". Please make sure to be online during this time to tell them the verification code sent to your number.";
                                                    } else if (value.social == 'youtube') {
                                                        comment += "You’ve given the escrow agent the email account for transferral of administrative rights. They will return administrative rights to you soon.";
                                                    } else if (value.social == 'fb') {
                                                        comment += "You’ve given the escrow agent a link to the page you want administrative rights transferred to. Soon, they will return administrative rights to you.";
                                                    }
                                                } else if (returnAccountInCancelledDeal.status == 2) {
                                                    if (value.social == 'youtube') {
                                                        comment += "The escrow agent has assigned your account as owner. You must <a href='https://myaccount.google.com/u/0/brandaccounts?si=1' target='_blank'>accept the invitation</a>. In 7 days they will be able to designate you as the primary owner or you can do that by yourself (7 days is the minimum amount of waiting time required in order to assign a new person as the primary owner in the control panel).";
                                                    }
                                                } else if (returnAccountInCancelledDeal.status == 3) {
                                                    if (value.social == 'youtube') {
                                                        comment += "7 days have passed. The escrow agent will designate your account as the primary owner soon.";
                                                    }
                                                } else if (returnAccountInCancelledDeal.status == 4) {
                                                    if (value.social == 'youtube') {
                                                        comment += "The escrow agent has returned to you primary ownership rights.";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else if (value.status_from == 20 && value.status_to == 20) {
                                    comment = "Someone has already paid for this page.";
                                }

                                actionsDiv += "<div class='deal-actions'>";

                                var cancelGarantBtn = "";

                                if (thisMessage.to == myId && value.status_from == 2 && (value.status_to == 1 || value.status_to == 2 || value.status_to == 10 || ((value.status_to == 12 || value.status_to == 13) && value.social == 'youtube'))) {
                                    cancelGarantBtn =
                                        "<a href='#' class='violet seller-cancel-deal'>Return payment to the buyer (cancel the transaction)</a>" +
                                        "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>";
                                }

                                actionsDiv +=
                                    "<div class='deal-action group'>" +
                                    cancelGarantBtn +
                                    "<div class='deal-cheat'>" +
                                    (!(adminNoty && adminNoty.call) ? "<a href='#'>I’ve been tricked! / There’s been some kind of problem - contact a live escrow agent</a>" : "<a href='#' class='link-disabled'>Live escrow agent has been contacted. They will investigate and verify everything during work hours.</a>") +
                                    "</div>" +
                                    "</div>" +
                                    "</div>";

                                html_messages +=
                                    "<div class='garant-container' data-social='" + value.social + "' data-id='" + value.id + "' data-event='" + ((thisGarantEvent && thisGarantEvent.status == 2) ? "true" : "false") + "'>" +
                                    "<div class='deal-desc'>" +
                                    "<h4>Request to purchase \"<a target='_blank' href='/group/" + value.group_id + "'>" + value.name + "</a>\"</h4>" +
                                    "<p><b>Transaction ID:</b> " + value.id + "</p>" +
                                    "<p><b>Transaction amount:</b> $<span class='deal-amount-span'>" + value.amount + "</span></p>" +
                                    "<div class='deal-desc__title'>Transaction steps when using the escrow service:</div>" +
                                    dealRules +
                                    "</div>" +
                                    (actionsReview ? "<div class='deal-actions'>" : '') +
                                    "<div class='deal-comment'>" +
                                    "<p>" + comment + "</p>" +
                                    infoInput +
                                    adminInstInfos +
                                    instInfos +
                                    actionsComment +
                                    "</div>" +
                                    (actionsReview ? "</div>" : '') +
                                    "<div class='deal-actions'>" +
                                    selectCond +
                                    actionsDiv +
                                    "</div>" +
                                    "</div>";

                                var updatedAt = ((value.social == 'youtube' && value.status_from == 2 && (value.status_to == 2 || value.status_to == 11)) ? value.transferred_at : value.updatedAt),
                                    myDate = new Date(),
                                    hours = null,
                                    days = 1;

                                if (value.status_from == 4) {
                                    hours = 3;
                                } else {
                                    hours = 24;
                                }

                                var setSeconds = Math.round(updatedAt + days * hours * 3600 - 1666109827);

                                myDate.setSeconds(setSeconds);
                                expireTimersList.push([".garant-timer-expire#countdown" + value.id, myDate]);

                                return false;
                            }
                        }, data.garants);
                    }
                });

                messageList.find(".simplebar-content").prepend(html_messages);


                $(".chat__messages[data-id='" + toId + "'] select").select2({
                    minimumResultsForSearch: -1
                });

                $.each($(".chat__messages[data-id='" + toId + "'] .message.media"), function() {
                    getOptimizationStatus($(this));
                    adjustMultiMediaMessageWitdth($(this).find(".inner"));
                });

                if (toId != 'admin') {
                    $.each(timersList, function() {
                        var type = this[2];
                        $(this[0]).countdown(this[1], function(event) {
                            $(this).html(
                                event.strftime(
                                    (type == 'youtube_waiting' ? '<div class="timer-wrapper"><div class="time">%D</div><span class="text">day</span></div>' : '') + '<div class="timer-wrapper"><div class="time">%H</div><span class="text">hour</span></div><div class="timer-wrapper"><div class="time">%M</div><span class="text">min</span></div><div class="timer-wrapper"><div class="time">%S</div><span class="text">sec</span></div>'
                                )
                            );
                        });
                    });

                    $.each(expireTimersList, function() {
                        $(this[0]).countdown(this[1], function(event) {
                            $(this).html(
                                event.strftime('%H:%M:%S')
                            );
                        });
                    });
                }
            }

            function loadDialog(dialog) {
                var toId = dialog.attr('data-id'),
                    list = $(".chat__messages[data-id='" + toId + "']"),
                    profileGroup = $(".chat-user[data-id='" + toId + "']"),
                    openGarantsBar = $(".open-garants-bar[data-id='" + toId + "']"),
                    time = (new Date()).getTime(),
                    garantsBar = $(".garants-bar[data-id='" + toId + "']");

                $(".chat__messages:visible").css('opacity', 0.25);
                $(".chat-user:visible").css('opacity', 0.25);
                $(".open-garants-bar:visible").css('opacity', 0.25);
                $(".garants-bar:visible").css('opacity', 0.25);

                $(".friend.group").removeClass('active');
                dialog.addClass('active');

                if (!list.length) {
                    if (parseInt(dialog.attr('data-last_load')) + 4000 > time)
                        return false;

                    dialog.attr('data-last_load', time);

                    return $.ajax({
                            url: "/chat/load",
                            data: {
                                to: toId,
                                _token: csrf
                            },
                            method: 'GET'
                        })
                        .always(function() {
                            $("#dialog-preloader").hide();
                        })
                        .done(function(data) {
                            if (data == 'empty') return data;

                            var garantOnline = data.garant_online;

                            if (toId != 'admin') {
                                var garantEvents = data.garant_events,
                                    adminNoty = data.admin_noty,
                                    dataUserTo = data.user;
                            }

                            var userToImg = 'images/seller.png';

                            if (toId != 'admin' && dataUserTo) {
                                userToImg = dataUserTo.img_path ? dataUserTo.img_path : '/images/seller.png';
                            }

                            var msgBlock = $('.chat__messages:last');

                            if (!msgBlock.length) msgBlock = $('.chat__friends:last');

                            var garantsBarList = "",
                                newEventNoties = "",
                                garantNeedAction = false;

                            if (!$.isEmptyObject(data.all_garants)) {
                                garantsBarList += "<ul>";

                                $.each(data.all_garants, function(index, value) {
                                    var garantName = value.name ? value.name : '',
                                        garantEvent = garantEvents[value.id],
                                        text = "",
                                        garantBarEvent = '';

                                    if (garantEvent && garantEvent.status) {
                                        garantNeedAction = true;

                                        if (garantEvent.status == 1) {
                                            text = 'An action is required';
                                        } else if (garantEvent.status == 2) {
                                            text = 'New event';
                                        }

                                        garantBarEvent = "<span class='garant-bar-event'>" + text + "</span>";

                                        newEventNoties +=
                                            "<div class='garant-msg-alert' data-id='" + value.id + "' data-type='new-event'>" +
                                            "<span>" + text + " in transaction id" + value.id + " (" + garantName + ")</span>" +
                                            '<div class="garant-event-arrow">' +
                                            '<span></span>' +
                                            '<span></span>' +
                                            '<span></span>' +
                                            '</div>' +
                                            "</div>";
                                    }

                                    garantsBarList +=
                                        "<li data-id='" + value.id + "'>" +
                                        "<p>" +
                                        "<b>ID" + value.id + " </b>" + garantName +
                                        "</p>" +
                                        garantBarEvent +
                                        "</li>";
                                });

                                garantsBarList += "</ul>";
                            } else {
                                garantsBarList = "<p>You don’t yet have any transactions with this user.</p>";
                            }

                            msgBlock.after(
                                "<div class='chat__messages' data-chat='" + data.chat_id + "' data-id='" + toId + "'>" +
                                "<div class='dialog-alerts-container'>" +
                                (data.msg_alert ?
                                    "<p class='garant-msg-alert' data-type='alert'>Be careful! All messages from the escrow agent have a black foreground to help identify them, so it’s impossible to confuse them with a regular message. Besides the escrow agent, there are no other third parties! REGULAR users’ messages appear with a white background! When the buyer has paid the seller, the transaction's status will be updated accordingly. If a dispute arises and it turns out that the transaction was not performed according to the rules specified above, the seller will be held responsible." +
                                    "<i class='fa fa-times' data-id='" + data.msg_alert.id + "'></i>" +
                                    "</p>" : "") +
                                (data.fast && data.fast > 10000000 ?
                                    "<div class='link-to-fast_deal'>" +
                                    "<p>Send this link to the " + data.who_joined + " so that they can accept the deal. You’ll be notified when they’ve accepted.</p>" +
                                    "<input readonly data-clipboard='true' value='https://accs-market.com/?deal=" + data.fast + "' class='form-control'>" +
                                    "</div>" : "") +
                                (data.msg_joined ?
                                    "<p class='garant-msg-alert' data-type='joined'>The " + data.who_joined + " entered the transaction." +
                                    "<i class='fa fa-times' data-id='" + data.msg_joined.id + "'></i>" +
                                    "</p>" : "") +
                                (data.msg_register ?
                                    "<p class='garant-msg-alert' data-type='register'>We recommend you <a href='#modal1' id='js-modal1' data-toggle='modal'>register</a> so that you don’t lose this message history." +
                                    "<i class='fa fa-times' data-id='" + data.msg_register.id + "'></i>" +
                                    "</p>" : "") +
                                newEventNoties +
                                "</div>" +
                                "<div class='messages-form'>" +
                                "<form>" +
                                "<textarea name='text' placeholder='Enter your message'></textarea>" +
                                "<img id='attach-files' src='/images/paperclip.png' alt='Attach'>" +
                                "<button type='submit'></button>" +
                                "</form>" +
                                "</div>" +
                                "<div class='message__list' " + (data.msg_alert ? "style='height: calc(100% - 45px); margin-top: 45px;'" : "") + ">" +
                                "<div class='message mine group typing'>" +
                                "<div class='message__photo'>" +
                                "<img src='" + userToImg + "' class='img-responsive img-circle'>" +
                                "<time datetime></time>" +
                                "</div>" +
                                "<div class='message__text'>" +
                                "<div class='inner'>" +
                                "<span>·</span>" +
                                "<span>·</span>" +
                                "<span>·</span>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                            );

                            new SimpleBar($(".chat__messages[data-id='" + toId + "'] .message__list")[0]);

                            drawMessages(data, toId);

                            if (toId != 'admin') {
                                var is_online = "",
                                    last_active = "";

                                if (data.is_online_to) {
                                    is_online = "style='display: block;'";
                                } else {
                                    last_active = "style='display: block;'";
                                }

                                if (data.user) {
                                    var groups = '',
                                        contacts = data.contacts_to,
                                        contactsTds =
                                        "<tr>" +
                                        "<td>E-mail:</td>" +
                                        "<td>" + ((contacts && contacts.show_email) ? data.user.email : "hidden") + "</td>" +
                                        "</tr>";

                                    if (contacts) {
                                        contactsTds +=
                                            "<tr>" +
                                            "<td>Name:</td>" +
                                            "<td>" + (contacts.fio ? contacts.fio : "not provided") + "</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                            "<td>Phone number:</td>" +
                                            "<td>" + (contacts.phone ? contacts.phone : "not provided") + "</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                            "<td>Skype:</td>" +
                                            "<td>" + (contacts.skype ? contacts.skype : "not provided") + "</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                            "<td>Telegram:</td>" +
                                            "<td>" + (contacts.tg ? contacts.tg : "not provided") + "</td>" +
                                            "</tr>" +
                                            "<tr>" +
                                            "<td>FB:</td>" +
                                            "<td>" + (contacts.fb ? contacts.fb : "not provided") + "</td>" +
                                            "</tr>";
                                    }

                                    if (data.groups_to) {
                                        $.each(data.groups_to, function(index, value) {
                                            groups +=
                                                "<div class='user-post'>" +
                                                "<p class='user-post__title'>" +
                                                "<a href='/group/" + value.id + "'>" + value.name + "</a>" +
                                                "</p>" +
                                                "<p>Subscribers: " + value.subscribers + "<br>Price: $" + value.price + "</p>" +
                                                "</div>"
                                        });
                                    } else {
                                        groups = "<p class='chat-no-groups'>This user does not yet have a listing.</p>";
                                    }
                                }

                                if (data.user) {
                                    $(".chat__close").after(
                                        "<div class='chat-user' data-id='" + data.user.id + "' style='display: block;'>" +
                                        "<div class='chat-user__info-data'>" +
                                        "<div class='chat-user__photo'>" +
                                        "<a href='/profile/" + data.user.real_nickname + "'>" +
                                        "<img src='" + data.img_to + "' class='img-responsive center-block img-circle'>" +
                                        "</a>" +
                                        "</div>" +
                                        "<p class='last-active-p' " + last_active + ">Last online " + data.last_active_to + "</p>" +
                                        "<div class='chat-user__state in' " + is_online + ">Online</div>" +
                                        "<div class='chat-user__name'>" +
                                        "<a href='/profile/" + data.user.real_nickname + "'>" + data.user.nickname + "</a>" +
                                        "</div>" +
                                        "<div class='chat-user__rating text-center'>" +
                                        "<div class='rate'>Rating: " + data.user.rating1 + "</div>" +
                                        "<div class='reviews'>" +
                                        "<a href='/profile/" + data.user.real_nickname + "' class='plus'>+" + data.reviews_plus_to + "</a>" +
                                        "<a href='/profile/" + data.user.real_nickname + "' class='middle'>" + data.reviews_middle_to + "</a>" +
                                        "<a href='/profile/" + data.user.real_nickname + "' class='minus'>-" + data.reviews_minus_to + "</a>" +
                                        "</div>" +
                                        data.userBadges_html +
                                        "</div>" +
                                        "<div class='chat-user__info'>" +
                                        "<table>" +
                                        "<tbody>" +
                                        contactsTds +
                                        "</tbody>" +
                                        "</table>" +
                                        "</div>" +
                                        "<div class='chat-user__posts'>" +
                                        "<p class='title'>Listings:</p>" +
                                        groups +
                                        "</div>" +
                                        "</div>" +
                                        "</div>" +
                                        "</div>" +
                                        "<div data-id='" + data.user.id + "' class='open-garants-bar open-garants-bar-user'>" +
                                        "<img " + (garantNeedAction ? "style='margin-left: 4px;'" : "") + " src='/images/garant-arrow.png'>" +
                                        "<img " + (garantNeedAction ? "style='display: none;'" : "") + " src='/images/handshake.png'>" +
                                        "<img " + (garantNeedAction ? "style='display: inline;'" : "") + " src='/images/alarm-bell-symbol.png'>" +
                                        "</div>" +
                                        "<div data-id='" + data.user.id + "' class='garants-bar'>" +
                                        "<b>List of transactions with this user</b>" +
                                        garantsBarList +
                                        "<div class='garant-bar-buttons'>" +
                                        "<a style='" + ((adminNoty && adminNoty.call) ? "display: none;" : "") + "' href='#' class='orange'>Contact the escrow agent</a>" +
                                        "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                        "<a style='" + (!(adminNoty && adminNoty.call) ? "display: none;" : "") + "' href='#' class='grey'>Escrow agent contacted</a>" +
                                        "<span style='" + (!garantOnline ? "display: none;" : "") + "' class='garant-online-yes-span'> — Online (" + garantOnlineFrom + " - " + garantOnlineTo + ")</span>" +
                                        "<span style='" + (garantOnline ? "display: none;" : "") + "' class='garant-online-no-span'> — Online " + garantOnlineFrom + " - " + garantOnlineTo + "</span>" +
                                        "</div>" +
                                        "</div>"
                                    );

                                    new SimpleBar($(".chat-user[data-id='" + data.user.id + "']")[0]);
                                    $('.chat-user[data-id="' + data.user.id + '"] [data-toggle="tooltip"]').tooltip();
                                } else {
                                    var onlineStrings = "";

                                    if (data.last_active_to != 'long ago') {
                                        onlineStrings =
                                            "<p class='last-active-p' " + last_active + ">Last online " + data.last_active_to + "</p>" +
                                            "<div class='chat-user__state in' " + is_online + ">Online</div>";
                                    }

                                    $(".chat__close").after(
                                        "<div class='chat-user chat-admin-profile-container' data-id='" + toId + "' style='display: block;'>" +
                                        "<div class='chat-user__info-data'>" +
                                        "<div class='chat-user__photo'>" +
                                        "<img src='/images/profile.png' class='img-responsive center-block img-circle'>" +
                                        "</div>" +
                                        onlineStrings +
                                        "<div class='chat-user__name'>" +
                                        "<a href='#'>Unknown</a>" +
                                        "</div>" +
                                        "</div>" +
                                        "</div>" +
                                        "<div data-id='" + toId + "' class='open-garants-bar open-garants-bar-user'>" +
                                        "<img " + (garantNeedAction ? "style='margin-left: 4px;'" : "") + " src='/images/garant-arrow.png'>" +
                                        "<img " + (garantNeedAction ? "style='display: none;'" : "") + " src='/images/handshake.png'>" +
                                        "<img " + (garantNeedAction ? "style='display: inline;'" : "") + " src='/images/alarm-bell-symbol.png'>" +
                                        "</div>" +
                                        "</div>" +
                                        "<div data-id='" + toId + "' class='garants-bar'>" +
                                        "<b>List of transactions with this user</b>" +
                                        garantsBarList +
                                        "<div class='garant-bar-buttons'>" +
                                        "<a style='" + ((adminNoty && adminNoty.call) ? "display: none;" : "") + "' href='#' class='orange'>Contact the escrow agent</a>" +
                                        "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                        "<a style='" + (!(adminNoty && adminNoty.call) ? "display: none;" : "") + "' href='#' class='grey'>Escrow agent contacted</a>" +
                                        "<span style='" + (!garantOnline ? "display: none;" : "") + "' class='garant-online-yes-span'> — Online (" + garantOnlineFrom + " - " + garantOnlineTo + ")</span>" +
                                        "<span style='" + (garantOnline ? "display: none;" : "") + "' class='garant-online-no-span'> — Online " + garantOnlineFrom + " - " + garantOnlineTo + "</span>" +
                                        "</div>"
                                    );

                                    new SimpleBar($(".chat-user[data-id='" + toId + "']")[0]);
                                }
                            } else {
                                var adminOnline = "";

                                if (data.garant_online) {
                                    adminOnline = "<span class='garant-online-yes-span'>Online (" + garantOnlineFrom + " - " + garantOnlineTo + ")</span>";
                                } else {
                                    adminOnline = "<span class='garant-online-no-span'>Online " + garantOnlineFrom + " - " + garantOnlineTo + "</span>";
                                }

                                $(".chat__close").after(
                                    "<div class='chat-user chat-admin-profile-container' data-id='admin' style='display: block;'>" +
                                    "<div class='chat-user__info-data'>" +
                                    "<div class='chat-user__photo'>" +
                                    "<img src='/images/friend3.png' class='img-responsive center-block img-circle'>" +
                                    "</div>" +
                                    "<div class='chat-user__name'>" +
                                    "<a href='#'>Agent " + (data.garant_online ? "(" + data.admin.name + ")" : "") + "</a>" +
                                    adminOnline +
                                    "<div class='chat-user__info'>" +
                                    "<table>" +
                                    "<tbody>" +
                                    "</tbody>" +
                                    "</table>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>"
                                );
                            }

                            list = $(".chat__messages[data-id='" + toId + "']");
                            profileGroup = $(".chat-user[data-id='" + toId + "']");

                            $(".chat__messages").hide();
                            list.css("cssText", "display: block!important;");
                            list.css('opacity', 1);

                            $(".chat-user").hide();
                            profileGroup.show();
                            profileGroup.css('opacity', 1);

                            $(".open-garants-bar").hide();
                            $(".garants-bar").hide();

                            if (toId != 'admin') {
                                openGarantsBar = $(".open-garants-bar[data-id='" + toId + "']");
                                garantsBar = $(".garants-bar[data-id='" + toId + "']");
                                openGarantsBar.show();
                                openGarantsBar.css('opacity', 1);
                                openGarantsBar.find('img:first-child').removeClass("rotated");
                                garantsBar.css('opacity', 1);
                                garantEventRead();
                            }

                            chatRead();
                            adjustMessageListHeight();
                            focusTextArea();

                            loadNewMessages = false;
                            setTimeout(function() {
                                loadNewMessages = true;
                            }, 1000);

                            $(".message__list .simplebar-content-wrapper").on('scroll', function() {
                                if (!$(this).closest('.message__list').attr('data-fully-loaded') && loadNewMessages && (isIntoView($(this).find(".simplebar-content > div:nth-child(2)")))) {
                                    var msgFrom = $(this).find(".simplebar-content > div[msg-id]").first().attr('msg-id'),
                                        toId = $(this).closest(".chat__messages").attr('data-id');
                                    loadMoreMessages(toId, msgFrom);
                                }
                                if (toId != 'admin') {
                                    garantEventRead();
                                    adjustGarantEventNoties($(this));
                                }
                                chatRead();
                            });
                        });
                } else {
                    $(".chat__messages").hide();
                    list.css("cssText", "display: block!important;");
                    list.css('opacity', 1);

                    $(".chat-user").hide();
                    profileGroup.show();
                    profileGroup.css('opacity', 1);

                    $(".open-garants-bar").hide();
                    $(".garants-bar").hide();

                    if (toId != 'admin') {
                        garantsBar.css('opacity', 1);
                        openGarantsBar.show();
                        openGarantsBar.css('opacity', 1);
                        openGarantsBar.find('img:first-child').removeClass("rotated");
                        garantEventRead();
                    }

                    $.each($(".chat__messages[data-id='" + toId + "'] .message.media"), function() {
                        getOptimizationStatus($(this));
                        adjustMultiMediaMessageWitdth($(this).find(".inner"));
                    });

                    setTimeout(function() {
                        loadNewMessages = true;
                    }, 1000);

                    chatRead();
                    focusTextArea();
                }

                return 'ready';
            }

            $("body").on('click', '.pay-garant-btn a', function(e) {
                e.preventDefault();

                var choosed = $(this).closest('.deal-action.group').find('.deal-action__select select').val(),
                    amount = parseFloat($(this).attr('data-amount')),
                    button = $(this),
                    preloader = button.next(),
                    container = $(this).closest('.garant-container'),
                    garantId = container.attr('data-id'),
                    discount = button.attr('data-discount'),
                    label = {
                        type: 'garant',
                        garant_id: garantId
                    };

                if (discount === 'true') {
                    var fee = 0.06;
                } else {
                    var fee = 0.07;
                }

                amount = amount * fee < 3 ? 3 : Math.round(amount * fee * 10) / 10;

                payOrder(choosed, amount, JSON.stringify(label), button, preloader, 'garant');
            });

            // function initGarantPaypalBtn(garantId, amount, discount)
            // {
            //     amount = parseFloat(amount);
            //
            //     if(discount){
            //         var fee = 0.06;
            //     }else{
            //         var fee = 0.07;
            //     }
            //
            //     var amount = amount * fee < 3 ? 3 : Math.round(amount * fee * 10) / 10;
            //
            //     paypal.Buttons({
            //         createOrder: function(data, actions) {
            //             return actions.order.create({
            //                 purchase_units: [{
            //                     amount: {
            //                         value: Math.round((amount + 0.30 + amount * 0.029) * 10) / 10
            //                     },
            //                     custom_id: 'g'+ garantId
            //                 }]
            //             });
            //         },
            //         onApprove: function(data, actions) {
            //             return actions.order.capture().then(function() {
            //                 var container     = $('.garant-container[data-id="'+ garantId +'"]'),
            //                     preloader     = container.find(".paypal-preloader"),
            //                     paypalOrderId = data.orderID;
            //
            //                 container.find(".deal-comment").hide();
            //                 container.find(".paypal-btn").remove();
            //                 preloader.show();
            //
            //                 setNoty("You’ve paid. We’re processing your payment...", 'success');
            //
            //                 gtag_report_conversion();
            //
            //                 $.ajax({
            //                     url: "/pay",
            //                     method: 'POST',
            //                     data: {
            //                         order_id: paypalOrderId
            //                     }
            //                 }).done(function(data){
            //                     if(data[0] == 'error'){
            //                         preloader.hide();
            //                         setNoty(data[1], 'error');
            //                     }
            //                 }).fail(function () {
            //                     preloader.hide();
            //                     unknowError();
            //                 });
            //             });
            //         }
            //     }).render('.garant-container[data-id="'+ garantId +'"] .paypal-btn');
            // }

            $('body').on('click', '.friend.group', function() {
                loadDialog($(this));
            });

            $("body").on('click', ".open-garants-bar", function() {
                var garantsBar = $(this).next().find('> ul');
                garantsBar.scrollTop(garantsBar[0].scrollHeight);
            });

            $("body").on('submit', '.garant-save-wallets-form', function(e) {
                e.preventDefault();

                var container = $(this).closest(".garant-container"),
                    preloader = container.find(".garant-save-wallets-form .wallets-preloader"),
                    wallet = $(this).find('input').val(),
                    button = $(this).find('button');

                button.hide();
                preloader.show();

                $.ajax({
                    url: "/refund_wallet",
                    data: {
                        garant_id: container.attr('data-id'),
                        wallet: wallet,
                        _token: csrf
                    },
                    method: 'POST'
                }).done(function(data) {
                    if (data[0] == 'error') {
                        preloader.hide();
                        button.show();
                        setNoty(data[1], 'error');
                    }
                }).fail(function() {
                    preloader.hide();
                    button.show();
                    unknowError();
                });
            });

            function adjustGarantEventNoties(container) {
                var docViewTop = container.scrollTop(),
                    windowWidth = $(window).width();

                $.each(container.closest(".chat__messages").find(".garant-msg-alert[data-type='new-event']"), function() {

                    var elem = $(".garant-container[data-id='" + $(this).attr('data-id') + "'] > .deal-comment"),
                        garantContainer = $(".garant-container[data-id='" + $(this).attr('data-id') + "']"),
                        elemTop = elem.offset().top;

                    if (windowWidth < 768) {
                        elemTop += 1500;
                    }

                    if (elemTop < docViewTop && !isIntoView(garantContainer[0]) && !isIntoView(garantContainer.find(".deal-desc")[0]) && !isIntoView(garantContainer.find(".deal-comment")[0])) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }

                    adjustMessageListHeight();
                });
            }

            function drawReviewForms(who, garantId, garantReview, userReview) {
                var actionsComment = '';

                if (garantReview) {
                    actionsComment =
                        "<form>" +
                        "<h5>Your review about the service:</h5>" +
                        "<textarea disabled='disabled' style='background: gainsboro;'>" + garantReview.review + "</textarea>" +
                        "</form>";
                } else {
                    actionsComment =
                        "<form class='give-service-review_form'>" +
                        "<textarea name='review'></textarea>" +
                        "<button type='submit'>Leave a review about the service</button>" +
                        "</form>";
                }

                var reviewTo = who == 'buyer' ? 'seller' : 'buyer';

                if (userReview) {
                    var reviewColor = '';

                    if (userReview.type == 1) {
                        reviewColor = "background-color: #60D260; border-color: green; color: white;";
                    } else if (userReview.type == 2) {
                        reviewColor = "background-color: #d3d3d3;";
                    } else if (userReview.type == 3) {
                        reviewColor = "background-color: #FF7474; color: white;";
                    }

                    actionsComment +=
                        "<form>" +
                        "<h5>Your review about the " + reviewTo + ":</h5>" +
                        "<textarea disabled='disabled' style='" + reviewColor + "'>" + userReview.review + "</textarea>" +
                        "<button class='change-review-btn'>Change review</button>" +
                        "</form>";
                } else {
                    actionsComment +=
                        "<form class='group give-user-review_form'>" +
                        "<textarea name='user_review'></textarea>" +
                        "<div class='deal-comment__select'>" +
                        "<select name='user_review_type' style='width: 100%'>" +
                        "<option value='1'>Positive</option>" +
                        "<option value='2'>Neutral</option>" +
                        "<option value='3'>Negative</option>" +
                        "</select>" +
                        "</div>" +
                        "<button type='submit'>Leave a review about the " + reviewTo + "</button>" +
                        "</form>";
                }

                return actionsComment;
            }

            function isScrolledIntoView(elem) {
                var docViewTop = $(window).scrollTop();
                var docViewBottom = docViewTop + $(window).height();

                var elemTop = $(elem).offset().top;
                var elemBottom = elemTop + $(elem).height();

                return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
            }

            var loadNew = true;

            $(".chat__friends .simplebar-content-wrapper").on('scroll', function() {
                if (isScrolledIntoView($(this).find(".friend.group:last")) && loadNew && $(this).find(".friend.group").length > 18) {
                    loadNew = false;

                    loadDialogs(false);
                }
            });

            var loadNewMessages = false;

            function loadDialogs(all) {
                if (all == 'start') {
                    $("#chat1").addClass('showed');
                    $("body").addClass('chat-open');

                    if ($(".chat-button1 a").attr('data-loaded')) {
                        return 'ok';
                    }
                }

                var ids = [];

                $('.friend.group').each(function() {
                    ids.push($(this).attr('data-id'));
                });

                return $.ajax({
                    url: '/chat/load/dialogs',
                    method: 'POST',
                    data: {
                        ids: ids,
                        all: all,
                        _token: csrf
                    }
                }).done(function(data) {
                    var firstDialog = null,
                        adminDialog = null,
                        garantEvents = data.garant_events;

                    if (data.admin_online) {
                        $(".friend.group[data-id='admin'] .friend__photo").addClass('is');
                    }

                    if (data.dialogs.length) {
                        $.each(data.dialogs, function(index, dialog) {
                            var message = data.last_messages[dialog.last_msg];

                            if (!message) return true;

                            if (dialog.to == 99999999) {
                                adminDialog = $(".friend.group[data-id='admin']");
                                var adminNoty = adminDialog.find(".friend__noty");

                                adminDialog.find(".friend__name + p").text(message.msg);
                                adminDialog.find(".friend__time").text(message.created_at_human).attr('data-time', message.timestamp).attr('msg-id', message.id);
                                adminNoty.text(dialog.count);

                                if (dialog.count) {
                                    adminDialog.attr('data-noty', 1);
                                }

                                adminDialog = dialog;
                            } else {
                                var user = data.users[dialog.to],
                                    garantEvent = garantEvents[dialog.id];

                                if (!firstDialog) firstDialog = dialog;

                                $(".chat__friends .simplebar-content").append(
                                    "<div class='friend group' data-chat_id='" + message.chat_id + "' data-id='" + dialog.to + "' " + (garantEvent ? "data-event='1'" : "") + " " + (dialog.count ? "data-noty='1'" : "") + ">" +
                                    "<div class='friend__photo " + (user && user.is_online ? 'is' : '') + "'>" +
                                    "<img src='" + (user && user.img_path ? user.img_path : '/images/profile.png') + "' class='img-responsive img-circle'>" +
                                    "</div>" +
                                    "<div class='friend__data'>" +
                                    "<p class='friend__name'>" + (user ? user.nickname : 'Unknown') + "</p>" +
                                    "<p>" + message.msg + "</p>" +
                                    "</div>" +
                                    "<div class='friend__time' msg-id='" + message.id + "' data-time='" + message.timestamp + "'>" + message.created_at_human + "</div>" +
                                    "<span class='friend__noty'>" + dialog.count + "</span>" +
                                    "<img class='dialog-alarm-bell' src='/images/alarm-bell-symbol.png'>" +
                                    "</div>"
                                );
                            }
                        });

                        loadNew = true;
                    }

                    if ((!firstDialog && adminDialog) || (adminDialog && Date.parse(firstDialog.updated_at) < Date.parse(adminDialog.updated_at))) {
                        $(".friend.group[data-id='admin']").addClass('active');
                    } else {
                        $(".friend.group:first").addClass('active');
                    }

                    if (all == 'start') {
                        $(".chat-button1 a").attr('data-loaded', 1);
                    }

                    $("#dialogs-preloader").hide();
                });
            }

            $("body").on('click', '.send-info-to-return-account a', function(e) {
                e.preventDefault();

                var container = $(this).closest('.garant-container'),
                    garantId = container.attr('data-id'),
                    actionBlock = $(this).closest(".deal-action"),
                    button = $(this),
                    info = container.find("textarea").val(),
                    preloader = actionBlock.find(".wallets-preloader");

                button.hide();
                preloader.show();

                $.ajax({
                    url: '/garant/send_info_to_return_account',
                    method: 'POST',
                    data: {
                        garant_id: garantId,
                        info: info,
                        _token: csrf
                    }
                }).done(function(data) {
                    if (data[0] == 'error') {
                        preloader.hide();
                        button.show();
                        setNoty(data[1], 'error');
                    }
                }).fail(function() {
                    preloader.hide();
                    button.show();
                    unknowError();
                });
            });

            $("body").on('click', ".decline-decision-btn a", function(e) {
                e.preventDefault();

                var garantId = $(this).closest('.garant-container').attr('data-id'),
                    actionBlock = $(this).closest(".deal-action"),
                    buttons = actionBlock.find(".deal-action__button"),
                    preloader = actionBlock.find(".wallets-preloader");

                buttons.hide();
                preloader.show();

                $.ajax({
                        url: '/cancel_deal',
                        method: 'POST',
                        data: {
                            garant_id: garantId,
                            _token: csrf
                        }
                    })
                    .done(function(data) {
                        if (data[0] == 'error') {
                            preloader.hide();
                            buttons.show();
                            setNoty(data[1], 'error');
                        }
                    })
                    .fail(function() {
                        unknowError();
                    });
            });

            $("body").on('click', ".confirm-cancel-btn a", function(e) {
                e.preventDefault();

                var garantId = $(this).closest('.garant-container').attr('data-id'),
                    actionBlock = $(this).closest(".deal-action"),
                    buttons = actionBlock.find(".deal-action__button"),
                    preloader = actionBlock.find(".wallets-preloader");

                buttons.hide();
                preloader.show();

                $.ajax({
                    url: '/cancel_confirmation',
                    method: 'POST',
                    data: {
                        garant_id: garantId,
                        _token: csrf
                    }
                }).fail(function() {
                    buttons.show();
                    preloader.hide();
                    unknowError();
                });
            });

            $("body").on('click', ".accept-decision-btn a[data-warning]", function(e) {
                e.preventDefault();

                var modal = $("#warning-modal"),
                    garantId = $(this).closest('.garant-container').attr('data-id')

                modal.find(".modal-block__desc p").text("Agree to continue the transaction without waiting only if the seller has provided you with evidence that he is selling his channel, which he created. Or bought it from the original owner. If he bought it from some supplier, there is a risk that the channel is stolen.");
                modal.find(".risk-btn").attr('data-decision', 2).attr('data-garant-id', garantId).addClass('risk-decision-btn');
                modal.modal('show');
            });

            $("body").on('click', ".accept-decision-btn a:not([data-warning]), .risk-decision-btn", function(e) {
                e.preventDefault();
                var garantId = $(this).attr('data-garant-id');

                if (!garantId) {
                    garantId = $(this).closest('.garant-container').attr('data-id')
                } else {
                    $("#warning-modal").modal('hide');
                }

                var container = $(".garant-container[data-id='" + garantId + "']"),
                    actionBlock = container.find(".admin_transfer-decision-action .deal-action"),
                    buttons = actionBlock.find(".deal-action__button"),
                    decision = $(this).attr('data-decision'),
                    preloader = actionBlock.find(".wallets-preloader");

                buttons.hide();
                preloader.show();

                $.ajax({
                        url: '/garant/accept_admin_transfer',
                        method: 'POST',
                        data: {
                            garant_id: garantId,
                            decision: decision,
                            _token: csrf
                        }
                    })
                    .done(function(data) {
                        if (data[0] == 'error') {
                            preloader.hide();
                            buttons.show();
                            setNoty(data[1], 'error');
                        }
                    })
                    .fail(function() {
                        unknowError();
                    });
            });


            $("body").on('submit', '.messages-form form', function(e) {
                e.preventDefault();

                var textarea = $(this).find('textarea'),
                    msg = textarea.val(),
                    block = $(this).closest('.chat__messages'),
                    to = block.attr('data-id');

                if (msg) {
                    textarea.val('');
                    textarea.css('background-color', '#DADFE1');
                    textarea.attr('disabled', 'disabled');

                    sendChatMessage(to, null, msg, null);
                }
            });

            $(document).on('click', "#attach-files", function() {
                var toId = $(".friend.group.active").attr('data-id'),
                    modal = $("#attach-files-modal");

                if (modal.attr('data-to') != toId) {
                    modal.attr('data-to', toId);
                    modal.attr('data-tmp', uniqueId());
                    clearDropzone($('#attachFilesDropzone'));
                }

                $("#attach-files-modal").modal('show');
            });

            function sendChatMessage(to, notUsed, msg, tmpId) {
                var msgId = Date.now(),
                    block = $(".chat__messages[data-id='" + to + "']"),
                    list = block.find(".message__list .simplebar-content-wrapper"),
                    textarea = block.find(".messages-form textarea");

                $.ajax({
                    url: "/chat/send",
                    data: {
                        msg: msg,
                        to: to,
                        tmp_id: tmpId,
                        _token: csrf
                    },
                    method: 'POST'
                }).done(function(data) {

                    typing = false;

                    var msgEl = $(".message.group[msg-id='" + msgId + "']");

                    if (data.hasOwnProperty('msg_id')) {
                        var timestamp = data.timestamp,
                            inner = msgEl.find(".inner");

                        msgEl.attr('msg-id', data.msg_id)
                        msgEl.find("time").attr('data-time', timestamp);
                        msgEl.attr("data-sent", 1);
                        msgEl.attr("data-admin-sent", data.admin_sent);

                        $(".friend.group[data-id='" + to + "'] .friend__time").attr('msg-id', data.msg_id).attr('data-time', timestamp);

                        if (data.uploads) {
                            msgEl.find(".media-item").remove();

                            if (data.uploads.length == 2) {
                                msgEl.find(".inner").addClass('two-media');
                            } else if (data.uploads.length > 2) {
                                msgEl.find(".inner").addClass('multiple-media');
                            }

                            $.each(data.uploads, function() {
                                var media = "";

                                if (this.type == 'image') {
                                    media = "<div class='media-item' data-type='image' data-path='" + this.path + "' data-id='" + this.id + "' style='background-image: url(" + this.path + ")'></div>";
                                } else if (this.type == 'video') {
                                    media = "<div class='media-item' data-type='video' data-status='transcoding' data-id='" + this.id + "'><img class='chat-media-preloader' src='/images/dialogs_preloader.gif' alt='Loading...'></div>";
                                }

                                msgEl.find(".inner .mobile-container").before(media);
                            });

                            getOptimizationStatus(msgEl);
                            adjustMultiMediaMessageWitdth(inner);
                        }

                        if (data.msg_register) {
                            block.find(".dialog-alerts-container").append(
                                "<p class='garant-msg-alert' data-type='register'>We recommend you <a href='#modal1' id='js-modal1' data-toggle='modal'>register</a> so that you don’t lose this message history." +
                                "<i class='fa fa-times' data-id='" + data.msg_register.id + "'></i>" +
                                "</p>"
                            );
                            adjustMessageListHeight();
                        }

                        if (data.request_push) {
                            savePushToken();
                        }

                        if (data.is_first) {
                            setNoty('Thank you for getting in touch. You should get a reply within 3-15 minutes (during work hours).', 'success');
                        }
                    } else if (data[0] == 'error') {
                        setNoty(data[1], 'error');
                        msgEl.remove();
                    } else {
                        setNoty('An error occurred, most likely the message was not sent, refresh the page.', 'error');
                    }

                    textarea.focus();
                }).fail(function() {
                    setNoty('An error occurred, most likely the message was not sent, refresh the page.', 'error');
                });

                setTimeout(function() {
                    list.find(".simplebar-content").append(
                        "<div class='message group " + (tmpId ? "media" : "") + "' msg-id='" + msgId + "'>" +
                        "<div class='message__photo'>" +
                        "<img src='" + $("#my-chat-img").text() + "' class='img-responsive img-circle'>" +
                        readIcons() +
                        "<time datetime data-time='" + now() + "'>1 sec</time>" +
                        "</div>" +
                        "<div class='message__text'>" +
                        "<div class='inner'>" + (tmpId ? "<div class='media-item'></div>" : msg) +
                        "<div class='mobile-container'>" +
                        readIcons() +
                        "<span class='mobile-msg-time'>1 sec</span>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                    );

                    $(".friend.group[data-id='" + to + "']").insertBefore('.friend.group:first');
                    $(".friend.group[data-id='" + to + "'] .friend__time").attr('msg-id', msgId)
                    $(".friend.group[data-id='" + to + "'] .friend__time").text('1 sec');

                    list.find(".message.mine.group.typing").insertAfter(list.find(".simplebar-content > div:last"));

                    list.animate({
                        scrollTop: list[0].scrollHeight
                    }, 500);

                    var toId = textarea.closest('.chat__messages').attr('data-id');
                    $(".friend.group[data-id='" + toId + "'] .friend__name + p").html(msg);

                    textarea.removeAttr('disabled');
                    textarea.removeAttr('style');

                    textarea.focus();
                }, 100);
            }

            $(".chat-button1 a, .show_chat").on('click', function(e) {
                e.preventDefault();

                $.when(loadDialogs('start')).done(function() {
                    if ($(window).width() > 767) {
                        var dialog = $(".friend.group.active");
                        loadDialog(dialog);
                    }
                });
            });

            function adjustMessageListHeight() {
                var alertsHeight = $(".dialog-alerts-container:visible").height();
                $('.message__list:visible').css('height', "calc(100% - " + alertsHeight + "px)").css('margin-top', alertsHeight);
            }

            $('.chat__close').on('click', function() {
                $("body").removeClass('chat-open');
            });

            $('body').on('keydown', '.messages-form textarea', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    $(this).closest('form').submit();
                }
            });

            function getPaymentMethods() {
                var methods = "<option value='13'>Visa/MasterCard (including USA, Canada)</option>" +
                    // "<option value='11'>Visa/MasterCard</option>" +
                    "<option value='1'>Crypto</option>" +
                    "<option value='2'>Local payment methods (PayOp)</option>" +
                    "<option value='3'>E-wallets (Payeer)</option>";
                // "<option value='12'>Qiwi, YooMoney, Perfect Money</option>";


                return methods;
            }

            function drawChatPaymentMethods(amount, discount, who) {
                var paymentMethods =
                    "<div class='deal-actions'>" +
                    "<div class='deal-action group'>" +
                    (who == 'seller' ?
                        "<p><b>Seller, if the buyer has any problems paying the fee for our services - you can pay it instead of him. In case of cancellation - fee will be refunded to your profile balance.</b></p>" : '') +
                    "<div class='deal-action__select'>" +
                    "<select name='payement' data-placeholder='Payment method' style='width: 100%'>" +
                    getPaymentMethods() +
                    "</select>" +
                    "</div>" +
                    "<div class='deal-action__button pay-garant-btn'>" +
                    "<a href='#' class='violet' data-discount='" + discount + "' data-amount='" + amount + "'>Pay</a>" +
                    "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                    "</div>" +
                    "</div>" +
                    "</div>";

                return paymentMethods;
            }

            function garantEventRead() {
                setTimeout(function() {
                    var garants = $(".garant-container[data-event='true']:visible"),
                        i = 0,
                        length = garants.length;

                    $.each(garants, function() {
                        if (isIntoView(this)) {
                            var toId = $(this).closest(".chat__messages").attr('data-id'),
                                container = $(this),
                                garantId = $(this).attr('data-id');

                            i++;

                            $.ajax({
                                url: "/garant/read/event",
                                data: {
                                    to: toId,
                                    garant_id: garantId,
                                    _token: csrf
                                },
                                method: 'POST'
                            }).done(function() {
                                container.attr('data-event', false);

                                if (i >= length) {
                                    $(".friend.group[data-id='" + toId + "']").attr("data-event", 0);
                                    var garantsBarOpen = $(".open-garants-bar[data-id='" + toId + "']");
                                    garantsBarOpen.find("img:first-child").css('margin-left', '5px');
                                    garantsBarOpen.find("img:nth-child(2)").show();
                                    garantsBarOpen.find("img:last-child").hide().css('margin-left', '6px');

                                    $(".garant-msg-alert[data-type='new-event'][data-id='" + garantId + "']").remove();
                                }

                                $(".garants-bar li[data-id='" + garantId + "'] .garant-bar-event").remove();
                            });
                        }
                    });

                    setTimeout(function() {
                        if (!$("#chat1 .dialog-alarm-bell:visible").length) {
                            $("#all-chat-alarm-bell").hide();
                        }
                    }, 1500);
                }, 300);
            }

            function isIntoView(elem) {
                var docViewTop = $(window).scrollTop();
                var docViewBottom = docViewTop + $(window).height();

                var elemTop = $(elem).offset().top;
                var elemBottom = elemTop + $(elem).height();

                return (((elemBottom <= docViewBottom) && (elemBottom >= docViewTop)) || ((elemTop <= docViewBottom) && (elemTop >= docViewTop)));
            }

            $(document).ready(function() {

                setInterval(function() {
                    var date = new Date(),
                        now = Math.floor(new Date(date.toUTCString()).getTime() / 1000);

                    $(".message.group time[data-time], .friend__time[data-time]").each(function() {
                        var time = $(this).attr('data-time'),
                            diff = Math.floor(now - time),
                            str = '';

                        if (diff < 60) {
                            str = 'sec';
                        } else {
                            diff = Math.floor(diff / 60);

                            if (diff < 60) {
                                str = 'min';
                            } else {
                                diff = Math.floor(diff / 60);

                                if (diff < 24) {
                                    // if(diff > 1){
                                    //     str = 'hours';
                                    // }else{
                                    //     str = 'hour';
                                    // }
                                    str = 'hr';
                                }
                            }
                        }

                        if (str) {
                            var text = diff + ' ' + str,
                                mobileTime = $(this).closest('.message').find(".mobile-msg-time");

                            $(this).text(text);

                            if (mobileTime.length) {
                                mobileTime.text(text);
                            }
                        }
                    });

                }, 10000);

            });
        </script>
        <script>
            var socketKey = 'token=0e0e866c5925f9bdb0dea0b2759c581c',
                socket = io('index.html', {
                    query: socketKey
                });

            socket.on('disconnect', function() {
                socket.connect('', {
                    query: socketKey
                });
            });


            socket.on("message", function(data) {
                setNoty('You’ve got a new message.', 'success');
                $(".chat-button1 span").text(data.all_noty);
                $(".chat-button1 span").show();

                var userId = data.user_from == 'admin' ? 'admin' : data.from_id,
                    dialog = $(".friend.group[data-id='" + userId + "']"),
                    list = $(".chat__messages[data-id='" + userId + "'] .message__list .simplebar-content-wrapper"),
                    timestamp = data.timestamp,
                    garantEvent = data.garant_event;

                if (!dialog.length && $(".chat-button1 a").attr('data-loaded') == 1 && !data.admin) {
                    var is_active = "";

                    if (data.is_online) {
                        is_active = 'is';
                    }

                    $('.chat__friends .simplebar-content').prepend(
                        "<div class='friend group' data-chat_id='" + data.chat_id + "' data-id='" + userId + "' data-noty='1'>" +
                        "<div class='friend__photo " + is_active + "'>" +
                        "<img src='" + (userId == 'admin' && !data.user_from ? '/images/profile.png' : data.img) + "' class='img-responsive img-circle'>" +
                        "</div>" +
                        "<div class='friend__data'>" +
                        "<p class='friend__name'>" + (userId == 'admin' ? "Escrow agent" : (data.user_from ? data.user_from.nickname : 'Unknown')) + "</p>" +
                        "<p>" + data.msg + "</p>" +
                        "</div>" +
                        "<div class='friend__time' data-time='" + timestamp + "' msg-id='" + data.msg_id + "'>" + data.created_at + "</div>" +
                        "<span class='friend__noty'>1</span>" +
                        "<img class='dialog-alarm-bell' src='/images/alarm-bell-symbol.png'>" +
                        "</div>"
                    );
                } else {
                    dialog.find(".friend__name + p").text(data.msg);
                    dialog.find(".friend__time").text(data.created_at);
                    dialog.find(".friend__time").attr('data-time', data.timestamp).attr('msg-id', data.msg_id);
                }

                if (list.length) {
                    list.find(".message.mine.group.typing").hide();

                    var uploadsHtml = drawChatUploads(data.uploads);

                    if (data.admin) {
                        list.find(".simplebar-content").append(
                            "<div class='message system group " + (uploadsHtml.filesCount ? "media" : "") + "' msg-id='" + data.msg_id + "'>" +
                            "<div class='message__photo'>" +
                            "<img src='/images/friend3.png' class='img-responsive img-circle'>" +
                            "<time datetime data-time='" + timestamp + "'>" + data.created_at + "</time>" +
                            "</div>" +
                            "<div class='message__text'>" +
                            "<div class='inner " + uploadsHtml.mediaQuantity + "' " + (data.admin_color ? "style='border: 2px solid " + data.admin_color + ";'" : "") + ">" + data.msg + uploadsHtml.mediaFiles + "<div class='mobile-container'><span class='mobile-msg-time'>" + data.created_at + "</span></div></div>" +
                            "</div>" +
                            "</div>"
                        );
                    } else {
                        var image = data.user_from ? data.user_from.img_path : null;

                        if (image == null) {
                            image = 'images/seller.png';
                        }

                        if (dialog.length) {
                            list.find(".simplebar-content").append(
                                "<div class='message mine group " + (uploadsHtml.filesCount ? "media" : "") + "' msg-id='" + data.msg_id + "'>" +
                                "<div class='message__photo'>" +
                                "<img src='" + image + "' class='img-responsive img-circle'>" +
                                "<time datetime data-time='" + timestamp + "'>" + data.created_at + "</time>" +
                                "</div>" +
                                "<div class='message__text'>" +
                                "<div class='inner " + uploadsHtml.mediaQuantity + "'>" + data.msg + uploadsHtml.mediaFiles + "<div class='mobile-container'><span class='mobile-msg-time'>" + data.created_at + "</span></div></div>" +
                                "</div>" +
                                "</div>"
                            );
                        }

                        if (!list.length) {
                            list = $(".chat__messages[data-id='" + userId + "'] .message__list .simplebar-content-wrapper");
                        }

                        if (data.hasOwnProperty('garant_id')) {
                            var dealRules = '';

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


                            var paymentMethods = data.payment_methods,
                                selectedMethods = "";

                            if (paymentMethods) {
                                selectedMethods +=
                                    "<div class='chat-payment-methods'>" +
                                    "<p>Payment methods chosen by the buyer. If you can accept one of them, agree to the deal. If none of them suit you, try to negotiate something else with him, and then agree.</p>" +
                                    "<ul>";

                                $.each(paymentMethods, function() {
                                    selectedMethods += "<li data-id='" + this.id + "'><img src='" + this.img + "' alt='" + this.name + "'></li>";
                                });

                                selectedMethods += "</ul></div>";
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
                                selectedMethods +
                                "<div class='deal-actions'>" +
                                "<div class='deal-action group'>" +
                                "<div class='deal-action__button accept-condition-btn'>" +
                                "<a href='#' class='orange' data-who='seller'>I agree with the terms of the transaction</a>" +
                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                "</div>" +
                                "</div>" +
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

                            $(".garants-bar[data-id='" + userId + "'] ul").append(
                                "<li data-id='" + data.garant_id + "'>" +
                                "<b>ID" + data.garant_id + "</b> " +
                                data.name +
                                "</li>"
                            );

                            list.find(".simplebar-content").append(
                                "<div class='message system group'>" +
                                "<div class='message__photo'>" +
                                "<img src='/images/friend3.png' class='img-responsive img-circle'>" +
                                "<time datetime data-time='" + timestamp + "'>1 sec</time>" +
                                "</div>" +
                                "<div class='message__text'>" +
                                "<div class='inner'>Be careful! All messages from the escrow agent have a black foreground to help identify them, so it’s impossible to confuse them with a regular message. Besides the escrow agent, there are no other third parties! REGULAR users’ messages appear with a white background! When the buyer has paid the seller, the transaction's status will be updated accordingly. If a dispute arises and it turns out that the transaction was not performed according to the rules specified above, the seller will be held responsible." +
                                "<div class='mobile-container'>" +
                                "<span class='mobile-msg-time'>1 sec</span>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                            );

                            list.find(".garant-container[data-id='" + data.garant_id + "'] select").select2({
                                minimumResultsForSearch: -1
                            });
                        }
                    }

                    list.find(".message.mine.group.typing").insertAfter(list.find('.simplebar-content > div:last'));

                    var msgEl = list.find(".message[msg-id='" + data.msg_id + "'].media");
                    if (msgEl.length) {
                        getOptimizationStatus(msgEl);
                        adjustMultiMediaMessageWitdth(msgEl.find(".inner"));
                    }
                }

                var dialog = $(".friend.group[data-id='" + userId + "']"),
                    noty = dialog.find(".friend__noty");

                noty.text(data.noty_count);
                dialog.attr('data-noty', 1);

                $(".friend.group[data-id='" + userId + "']").insertBefore('.friend.group:first');

                if (garantEvent && garantEvent.status > 0) {
                    setGarantEvent(garantEvent, userId);
                }

                if (list.is(':visible')) {
                    var lastMessage = list.find(".message:not(.typing):last");
                    if (data.hasOwnProperty('garant_id')) {
                        lastMessage = lastMessage.prev().prev().prev();
                    }

                    if (isIntoView(lastMessage) || isIntoView(lastMessage.prev(".message"))) {
                        list.animate({
                            scrollTop: list[0].scrollHeight
                        }, 0);
                    }

                    chatRead();
                    garantEventRead();
                }
            });

            function setGarantEvent(garantEvent, userId, event) {
                if (garantEvent) {
                    var garantLi = $(".garants-bar li[data-id='" + garantEvent.garant_id + "']"),
                        container = $(".garant-container[data-id='" + garantEvent.garant_id + "']");

                    garantLi.find('span').remove();

                    if (garantEvent.status) {
                        if (event) setNoty('A new transaction event.', 'success');

                        if (garantEvent.status == 1) {
                            var text = 'An action is required';
                        } else if (garantEvent.status == 2) {
                            var text = 'New event';
                            $(".garant-container[data-id='" + garantEvent.garant_id + "']").attr('data-event', true);
                        }

                        garantLi.append("<span class='garant-bar-event'>" + text + "</span>");

                        $(".friend.group[data-id='" + userId + "']").attr("data-event", 1);

                        $(".open-garants-bar[data-id='" + userId + "'] img:first-child").css('margin-left', '4px');
                        $(".open-garants-bar[data-id='" + userId + "'] img:nth-child(2)").hide();
                        $(".open-garants-bar[data-id='" + userId + "'] img:last-child").css('display', 'inline').css('margin-left', '2px');

                        var garantName = $(".garant-container[data-id='" + garantEvent.garant_id + "'] h4 a").text();

                        $(".garant-msg-alert[data-type='new-event'][data-id='" + garantEvent.garant_id + "']").remove();
                        $(".chat__messages[data-id='" + userId + "'] .dialog-alerts-container").append(
                            "<div class='garant-msg-alert' data-id='" + garantEvent.garant_id + "' data-type='new-event'>" +
                            "<span>" + text + " in transaction id" + garantEvent.garant_id + " (" + garantName + ")</span>" +
                            '<div class="garant-event-arrow">' +
                            '<span></span>' +
                            '<span></span>' +
                            '<span></span>' +
                            '</div>' +
                            "</div>"
                        );

                        adjustGarantEventNoties($(".chat__messages[data-id='" + userId + "'] .message__list .simplebar-content-wrapper"));

                        $("#all-chat-alarm-bell").css('display', 'inline');
                    } else {
                        completeGarantAction(container);
                    }
                }
            }

            $("body").on('click', '.deal-cheat a, .garant-bar-buttons .orange', function(e) {
                e.preventDefault();

                var toId = $(this).closest('.chat__messages').attr('data-id'),
                    btn = $(this),
                    prel = btn.closest(".garant-bar-buttons").find(".wallets-preloader");

                btn.hide();
                prel.show();

                if (!toId) {
                    toId = $(this).closest('.garants-bar').attr('data-id');
                }

                var a = $(".chat__messages[data-id='" + toId + "']").find(".deal-cheat a"),
                    bar = $(".garants-bar[data-id='" + toId + "'] .garant-bar-buttons");

                $.ajax({
                    url: "/garant/call",
                    data: {
                        to: toId,
                        _token: csrf
                    },
                    method: 'POST'
                }).done(function() {
                    a.addClass('link-disabled');
                    a.text('Live escrow agent has been contacted. They will investigate and verify everything during work hours.');

                    prel.hide();
                    bar.find(".grey").show();

                    setNoty('Live escrow agent has been contacted. Please describe your issue with the transaction (they’ll be able to see previous messages). They will investigate and verify everything during work hours.', 'success');
                });
            });
        </script>
        <script>
            socket.on("garant", function(data) {
                if (data.type == 'reload_page') {
                    location.reload();
                    return false;
                }

                var container = $(".garant-container[data-id='" + data.garant_id + "']"),
                    expireTimersList = [];

                if (data.type == 'transferred' || data.type == 'money_sent' || data.type == 'received' || data.type == 'money_received' || data.type == 'cancel_deal_timer' || data.type == 'cancel_deal_confirmation' || data.type == 'update_return_account_status') {
                    container.find(".deal-comment input, .deal-comment .deal-actions").remove();
                    container.find("> .deal-actions:not(:last-of-type)").remove();
                    container.find(".deal-actions .deal-actions:not(:last-of-type)").remove();
                    container.find(".garant-timer-block").remove();
                }

                if (data.type == 'accept_condition') {
                    var container = $(".garant-container[data-id='" + data.garant_id + "']");

                    if (data.who == 'buyer') {
                        container.find('.deal-comment p').text("The terms of the transaction were confirmed. When you send your payment, the seller will be notified, and will need to transfer the account login details based on the agreed upon terms. If the seller does not respond, or breaks the rules, you can call upon the escrow agent (button below).");
                        container.find('.deal-comment').after(drawChatPaymentMethods(data.amount, data.discount, 'buyer'));
                    } else if (data.who == 'seller') {
                        container.find('.deal-comment p').text("The terms of the transaction were confirmed, awaiting payment. Do not transfer the account directly! Follow the instructions on this page once the buyer has paid.");
                        container.find('.deal-comment').after(drawChatPaymentMethods(data.amount, data.discount, 'seller'));
                    }
                } else if (data.type == 'payed') {
                    var statusText = container.find('.deal-comment p');

                    if (data.conversion_id) {
                        gtag_report_conversion(data.conversion_id);
                    }

                    container.find(".deal-actions:first").remove();

                    if (data.who == 'buyer') {
                        if (data.social == 'fb') {
                            statusText.html("You’ve paid, and we’ve notified the seller. Waiting for them to transfer login details to the escrow agent. As soon as they transfer them and the escrow agent has verified everything, we will notify you so that you can transfer payment to the seller. The seller has <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> left to do this, after which we will offer you a refund.");
                        } else if (data.social == 'in' || data.social == 'twitter') {
                            statusText.html("You’ve paid, and we’ve notified the seller. Waiting for them to transfer login details to the escrow agent. As soon as they transfer them and the escrow agent has verified everything, we will notify you so that you can transfer payment to the seller. The seller has <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> left to do this, after which we will offer you a refund.");
                        } else if (data.social == 'tg') {
                            statusText.html("You’ve paid, and we’ve notified the seller. We’re waiting for the seller to send the escrow agent the phone number associated with the creator’s account. The seller has <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> left to do this, after which we will offer you a refund.");
                        } else if (data.social == 'youtube') {
                            statusText.html("You’ve paid, and we’ve notified the seller. We’re waiting for the seller to assign the escrow agent as manager. The seller has <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> left to do this, after which we will offer you a refund.");
                        }

                        container.find('.deal-comment').show();

                        if (data.social != 'in' && data.social != 'twitter') {
                            statusText.after(
                                "<input type='text' class='form-control' style='width: 100%;' value='" + data.info + "' readonly>"
                            );
                        }
                    } else if (data.who == 'seller') {
                        if (data.social == 'fb') {
                            statusText.html("The buyer has paid the escrow agent's commission. Now, you need to assign the escrow agent’s page as the administrator (shown below), and then leave the group/page. After this, our moderator will verify everything, and notify the buyer to pay you. You have <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> to do this, after which we will offer the buyer a refund.");
                            statusText.after(
                                "<input type='text' class='form-control' style='width: 100%;' value='" + data.admin_link + "' readonly>"
                            );
                        } else if (data.social == 'in' || data.social == 'twitter') {
                            statusText.html("The buyer has paid. Now, you need to fill in the field below with the login details for your account, as well as for the original email associated with the account." + (data.social == 'in' ? " <b>Make sure to first disconnect your Instagram account from your Facebook account (if they’re linked together).</b>" : "") + " After this, our moderator will verify the account details and notify the buyer for them to pay you. You have <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> to do this, after which we will offer the buyer a refund.");

                            statusText.after(
                                "<div class='deal-actions'>" +
                                "<div class='deal-comment'>" +
                                "<textarea class='instagram-infos' name='instagram-infos' placeholder='Please enter the aforementioned details here'></textarea>" +
                                "</div>" +
                                "</div>"
                            );
                        } else if (data.social == 'tg') {
                            statusText.html("The buyer has paid, now you need to fill in the field below with the phone number associated with the creator’s account. The escrow agent will log into your account and associate their own phone number with it, after which they will notify the buyer for them to pay you. In order to log in, the escrow agent will ask you for the verification code that you will receive to your phone. The escrow agent is online from " + garantOnlineFrom + " to " + garantOnlineTo + ". Please make sure to be online during this time to tell the escrow agent the verification code. You have <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> to do this, after which we will offer the buyer a refund.");
                            statusText.after(
                                "<div class='deal-actions'>" +
                                "<div class='deal-comment'>" +
                                "<textarea class='instagram-infos' name='instagram-infos' placeholder='Please enter the aforementioned details here'></textarea>" +
                                "</div>" +
                                "</div>"
                            );
                        } else if (data.social == 'youtube') {
                            statusText.html("The buyer has paid. Now, you need to assign the escrow agent’s account as a manager. The escrow agent’s email is indicated below. If you don’t have a button for transferring administrative rights, that means you have not yet linked the channel with the brand’s account. Follow <a target='_blank' href='https://support.google.com/youtube/answer/3056283'>these instructions</a> in order to link your account. You have <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> to do this, after which we will offer the buyer a refund.");
                            statusText.after("<input type='text' class='form-control' style='width: 100%;' value='" + data.youtube_email + "' readonly>");

                            // statusText.after(
                            //     "<div class='youtube-transfer-manager-info'>" +
                            //     "<b>Escrow agent</b>" +
                            //     "<input type='text' class='form-control' style='width: 100%;' value='"+ data.youtube_email +" (manager)' readonly>" +
                            //     "<b>Buyer</b>" +
                            //     "<input type='text' class='form-control' style='width: 100%;' value='"+ data.info +" (communications manager)' readonly>" +
                            //     "</div>"
                            // );
                        }

                        var btnText = null,
                            notJoinedText = '';

                        if (data.social == 'in' || data.social == 'twitter' || data.social == 'tg') {
                            btnText = "Submit data for review";
                        } else if (data.social == 'youtube') {
                            btnText = "Assigned the escrow agent as manager";
                        } else if (data.social == 'fb') {
                            btnText = "Assigned the escrow agent administrative rights";
                        }

                        if (data.social == 'fb') {
                            notJoinedText = "<p class='not-joined-p'>If this page isn’t a member of the group, contact the escrow agent and ask them to join.</p>";
                        }

                        container.find(".deal-cheat").closest(".deal-action").append(
                            "<a href='#' class='violet seller-cancel-deal'>Return payment to the buyer (cancel the transaction)</a>" +
                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>"
                        );

                        container.find('> .deal-comment').after(
                            "<div class='deal-actions'>" +
                            "<div class='deal-action group'>" +
                            "<div class='deal-action__button garant-transferred-btn'>" +
                            "<a href='#' class='orange'>" + btnText + "</a>" +
                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                            "</div>" +
                            notJoinedText +
                            "</div>" +
                            "</div>"
                        );
                    }
                } else if (data.type == 'transferred') {
                    var statusText = container.find('.deal-comment p'),
                        timerExpire = null;

                    if (data.social == 'fb') {
                        if (data.who == 'buyer') {
                            statusText.text("The seller has transferred administrative rights to the escrow agent. The escrow agent will verify this and notify you soon, so that you can pay the seller.");
                        } else {
                            statusText.text("You’ve transferred administrative rights to the escrow agent. They will verify this soon and notify the buyer, for them to pay you.");
                        }
                    } else if (data.social == 'in' || data.social == 'twitter') {
                        if (data.who == 'buyer') {
                            statusText.text("The seller has transferred the account as well as the associated email to the escrow agent. The escrow agent will verify this soon, and then change the password on the account and on the associated original email. When this is done, they will notify you so that you can pay the seller.");
                        } else {
                            statusText.text("You’ve sent the requested details to the escrow agent. They will verify everything soon, change the password on the account and on the associated original email, and then notify the buyer for them to pay you.");
                        }
                    } else if (data.social == 'tg') {
                        if (data.who == 'buyer') {
                            statusText.text("The seller has given the phone number to the escrow agent. The escrow agent will request a verification code soon, in order to login to the account and verify everything. Once everything is verified, they will associate their own phone number with the account and notify you so that you can pay the seller.");
                        } else {
                            statusText.text("You’ve sent the phone number associated with the account to the escrow agent. The escrow agent is online between " + garantOnlineFrom + " to " + garantOnlineTo + ". Please make sure to be online during this time, so that you can give them the verification code sent to your phone.");
                        }
                    } else if (data.social == 'youtube') {
                        if (data.status_to == 2) {
                            if (data.who == 'buyer') {
                                statusText.html("The seller has designated the escrow agent's account as the channel's manager. The escrow agent will now verify this and begin the 7 days timer, after which the seller will designate the escrow agent as the primary owner (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel).");
                            } else {
                                container.find(".youtube-transfer-manager-info").remove();
                                statusText.html("You've designated the escrow agent as the channel's manager. They will now verify this and begin the 7 days timer, after which you need to transfer primary ownership rights to them (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel).");
                            }
                        } else if (data.status_to == 11) {
                            if (data.who == 'buyer') {
                                statusText.html("The seller has transferred primary ownership rights to the escrow agent. The escrow agent will now verify this, and remove all the other managers. They will then notify you to pay the seller.");
                            } else {
                                statusText.html("You’ve transferred primary ownership rights to the escrow agent. They will verify this soon and notify the buyer, for them to pay you.");
                            }
                        }
                    }

                    if (timerExpire) {
                        $(timerExpire[0]).countdown(timerExpire[1], function(event) {
                            $(this).html(
                                event.strftime('%H:%M:%S')
                            );
                        });
                    }
                } else if (data.type == 'account_received_by_garant') {
                    var statusText = container.find('.deal-comment p');

                    if (data.status_to == 12 && data.social == 'youtube') {
                        var waitDecision = data.wait_decision,
                            waitTime = 21 - waitDecision.from_creation,
                            btnTxt = "",
                            msgTemplate = "The escrow agent has become a manager. ",
                            btnDisabled = "";

                        if (data.who == 'buyer') {
                            statusText.html(msgTemplate + "We suggest you wait " + waitTime + " " + getDayStr(waitTime) + " in case the channel is stolen. In most cases, if the channel is indeed stolen, its true owner restores it within 3 weeks." + (waitDecision.from_creation ? " Since the listing was created " + (waitDecision.from_creation) + " " + getDayStr(waitDecision.from_creation) + " ago, it remains to wait only " + waitTime + " " + getDayStr(waitTime) + "." : ""));

                            if (waitDecision.seller == 1) {
                                btnTxt = " (seller agreed)";
                            } else if (waitDecision.seller == 2 || waitDecision.buyer == 1) {
                                if (waitDecision.buyer == 1) {
                                    btnTxt = " (waiting for the seller's agreement)";
                                } else {
                                    btnTxt = " (seller refused)";
                                }

                                btnDisabled = " link-disabled";
                            }

                            container.find(".deal-comment").after(
                                "<div class='deal-actions admin_transfer-decision-action'>" +
                                "<div class='deal-action group'>" +
                                "<div class='deal-action__button accept-decision-btn'>" +
                                "<a href='#' class='orange" + btnDisabled + "' data-decision='1'>I agree to wait " + waitTime + " " + getDayStr(waitTime) + btnTxt + "</a>" +
                                "</div>" +
                                "<div class='deal-action__button accept-decision-btn'>" +
                                "<a href='#' class='risk-btn' data-decision='2' data-warning='1'>I agree without waiting (only 7 days)</a>" +
                                "</div>" +
                                "<div " + (waitDecision.seller != 2 ? "style='display: none;'" : "") + " class='deal-action__button decline-decision-btn'>" +
                                "<a href='#' class='violet'>Return payment (cancel the transaction)</a>" +
                                "</div>" +
                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                "</div>" +
                                "</div>"
                            );
                        } else {
                            statusText.html(msgTemplate + "We suggested the buyer wait " + waitTime + " " + getDayStr(waitTime) + " in case the channel is stolen. In most cases, if the channel is indeed stolen, its true owner restores it within 3 weeks." + (waitDecision.from_creation ? " Since the listing was created " + (waitDecision.from_creation) + " " + getDayStr(waitDecision.from_creation) + " ago, it remains to wait only " + waitTime + " " + getDayStr(waitTime) + "." : "") + " The buyer also has the opportunity to continue the transaction without waiting at his own risk.");

                            var waitBtnTxt = " (also agree to continue immediately)",
                                waitBtnDisabled = "";

                            if (waitDecision.buyer == 1) {
                                btnTxt = " (buyer refused)";
                                waitBtnTxt = "";
                                btnDisabled = " link-disabled";
                            } else if (waitDecision.seller == 1) {
                                waitBtnTxt = " (waiting for the buyer's agreement)";
                                waitBtnDisabled = " link-disabled";
                            } else if (waitDecision.seller == 2) {
                                btnTxt = " (waiting for the buyer's agreement)";
                                btnDisabled = " link-disabled";
                            }

                            container.find(".deal-comment").after(
                                "<div class='deal-actions admin_transfer-decision-action'>" +
                                "<div class='deal-action group'>" +
                                "<div class='deal-action__button accept-decision-btn'>" +
                                "<a href='#' class='orange" + waitBtnDisabled + "' data-decision='1'>I agree to wait " + waitTime + " " + getDayStr(waitTime) + waitBtnTxt + "</a>" +
                                "</div>" +
                                "<div class='deal-action__button accept-decision-btn'>" +
                                "<a href='#' class='risk-btn" + btnDisabled + "' data-decision='2'>I agree only without waiting" + btnTxt + "</a>" +
                                "</div>" +
                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                "</div>" +
                                "</div>"
                            );
                        }
                    } else {
                        if (data.who == 'buyer') {
                            if (data.social == 'in' || data.social == 'twitter') {
                                statusText.html("The escrow agent has obtained access to the account and changed the login details so that the seller cannot regain access. Now, you need to pay the seller. If they have not yet given you their payment details, please ask them. After the seller has confirmed that they’ve received the payment, the escrow agent will send you the account details. <b>When you transfer money via Paypal, you must choose the method of sending to a friend. If you choose to pay as for goods or services, you will have the opportunity to refund your payment after the end of the transaction when you already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. The seller will receive the same message so he can double-check on his side if you've sent him the payment correctly.</b>");
                            } else if (data.social == 'youtube') {
                                if (data.status_to == 8) {
                                    statusText.html("The escrow agent has become a manager. In 7 days the seller will be able to transfer primary ownership rights to them (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel).");
                                } else if (data.status_to == 10) {
                                    statusText.html("The escrow agent has become the primary owner and has removed all the other managers. Now, you need to pay the seller. If they have not yet given you their payment details, please ask them. After the seller has confirmed that they’ve received the payment, the escrow agent will designate you as the channel’s owner. <b>When you transfer money via Paypal, you must choose the method of sending to a friend. If you choose to pay as for goods or services, you will have the opportunity to refund your payment after the end of the transaction when you already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. The seller will receive the same message so he can double-check on his side if you've sent him the payment correctly.</b>");
                                }
                            } else if (data.social == 'fb') {
                                statusText.html("The escrow agent has received administrative rights and verified that the seller has removed themselves from the list of administrators. Now, you need to pay the seller. If they have not yet given you their payment details, please ask them. After the seller has confirmed that they’ve received the payment, the escrow agent will transfer administrative rights to you. <b>When you transfer money via Paypal, you must choose the method of sending to a friend. If you choose to pay as for goods or services, you will have the opportunity to refund your payment after the end of the transaction when you already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. The seller will receive the same message so he can double-check on his side if you've sent him the payment correctly.</b>");
                            } else if (data.social == 'tg') {
                                statusText.html("The escrow agent has received access to the creator’s account and changed their phone number, so that the seller cannot restore access to the account. Now, you need to pay the seller. If they have not yet given you their payment details, please ask them. After the seller has confirmed that they’ve received the payment, the escrow agent will associate your phone number with the account. <b>When you transfer money via Paypal, you must choose the method of sending to a friend. If you choose to pay as for goods or services, you will have the opportunity to refund your payment after the end of the transaction when you already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. The seller will receive the same message so he can double-check on his side if you've sent him the payment correctly.</b>");
                            }

                            if (!(data.social == 'youtube' && data.status_to == 8))
                                statusText.after(
                                    "<div class='deal-actions'>" +
                                    "<div class='deal-action group'>" +
                                    "<div class='deal-action__button money-sent-to-seller-btn' style='margin-left: 0;'>" +
                                    "<a href='#' class='orange'>Paid the seller</a>" +
                                    "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>"
                                );
                        } else if (data.who == 'seller') {
                            if (data.status_to == 8 && data.social == 'youtube') {
                                statusText.html("The escrow agent has become a manager. In 7 days you need to transfer primary ownership rights to them (7 days is the minimum amount of time required in order to assign a new primary owner in the control panel).");
                            } else {
                                statusText.html("The escrow agent has received access to the account. Now the buyer needs to pay you. Give them your payment details. <b>If the buyer pays you via PayPal, you must make sure that they sent you the money as a transfer to a friend, and not as a payment for items or services. In this case buyer will have the opportunity to refund the payment after the end of the transaction, when they already received the account. Paypal support team in this cases always refunds the payment without any examination of the issue. Escrow service in this kind of situations can't offer enough protection for sellers. To make sure that the transfer is correct, you must open the PayPal transaction and check that the address for sending the goods was not indicated there. If the address is indicated, you must return the money back to buyer and ask them to pay you as specified in this message.</b>");
                            }
                        }

                        if (data.social == 'youtube' && data.status_to == 8) {
                            container.find(".admin_transfer-decision-action").remove();

                            statusText.after(
                                "<div class='garant-timer-block'>" +
                                "<b>Primary ownership rights can be transferred in:</b>" +
                                "<div class='garant-timer' id='countdown" + data.garant_id + "'></div>" +
                                "</div>"
                            );

                            var myDate = new Date();

                            myDate.setSeconds(Math.round(7 * 24 * 3600));

                            $(".garant-timer#countdown" + data.garant_id).countdown(myDate, function(event) {
                                $(this).html(
                                    event.strftime(
                                        '<div class="timer-wrapper"><div class="time">%D</div><span class="text">day</span></div><div class="timer-wrapper"><div class="time">%H</div><span class="text">hour</span></div><div class="timer-wrapper"><div class="time">%M</div><span class="text">min</span></div><div class="timer-wrapper"><div class="time">%S</div><span class="text">sec</span></div>'
                                    )
                                );
                            });
                        }
                    }
                } else if (data.type == 'admin_transferred') {
                    var comment = container.find('.deal-comment'),
                        statusText = comment.find('p');

                    if (data.social == 'youtube') {
                        if (data.who == 'buyer') {
                            statusText.html("Transaction completed successfully! The escrow agent has assigned your account as owner. You must <a href='https://myaccount.google.com/u/0/brandaccounts?si=1' target='_blank'>accept the invitation</a>. In 7 days they will be able to designate you as the primary owner or you can do that by yourself (7 days is the minimum amount of waiting time required in order to assign a new person as the primary owner in the control panel).");
                        } else {
                            statusText.text("Transaction completed successfully! The escrow agent has assigned the buyer as owner. In 7 days they will be able to designate them as the primary owner or the buyer can do that by himself (7 days is the minimum amount of waiting time required in order to assign a new person as the primary owner in the control panel).");
                        }

                        var myDate = new Date();

                        myDate.setSeconds(Math.round(7 * 24 * 3600));

                        $(".garant-timer#countdown" + data.garant_id).countdown(myDate, function(event) {
                            $(this).html(
                                event.strftime(
                                    '<div class="timer-wrapper"><div class="time">%D</div><span class="text">day</span></div><div class="timer-wrapper"><div class="time">%H</div><span class="text">hour</span></div><div class="timer-wrapper"><div class="time">%M</div><span class="text">min</span></div><div class="timer-wrapper"><div class="time">%S</div><span class="text">sec</span></div>'
                                )
                            );
                        });

                        comment.append(drawReviewForms(data.who));
                        comment.wrap("<div class='deal-actions'></div>");
                    }
                } else if (data.type == 'waiting_update_decision') {
                    var decision = data.decision,
                        waitTime = 21 - decision.from_creation,
                        who = data.who,
                        actionBlock = container.find(".admin_transfer-decision-action .deal-action"),
                        buttons = actionBlock.find(".deal-action__button"),
                        acceptBtn = buttons.find(".orange"),
                        waitText = "I agree to wait " + waitTime + " " + getDayStr(waitTime),
                        preloader = actionBlock.find(".wallets-preloader");

                    preloader.hide();
                    buttons.show();

                    if (who == 'buyer') {
                        var btnTxt = waitText;

                        acceptBtn.removeClass('link-disabled');

                        if (decision.seller == 1) {
                            btnTxt += " (seller agreed)";
                        } else if (decision.seller == 2 || decision.buyer == 1) {
                            if (decision.buyer == 1) {
                                btnTxt += " (waiting for the seller's agreement)";
                            } else {
                                btnTxt += " (seller refused)";
                            }

                            acceptBtn.addClass('link-disabled');
                        }

                        if (decision.seller == 2) {
                            actionBlock.find(".decline-decision-btn").show();
                        } else {
                            actionBlock.find(".decline-decision-btn").hide();
                        }

                        acceptBtn.text(btnTxt);
                    } else {
                        var btnTxt = "I agree only without waiting",
                            waitBtnTxt = waitText,
                            riskBtn = buttons.find(".risk-btn");

                        acceptBtn.removeClass('link-disabled');
                        riskBtn.removeClass('link-disabled');

                        if (decision.buyer == 1) {
                            btnTxt += " (buyer refused)";
                            riskBtn.addClass('link-disabled');
                        } else if (decision.seller == 1) {
                            waitBtnTxt += " (waiting for the buyer's agreement)";
                            acceptBtn.addClass('link-disabled');
                        } else if (decision.seller == 2) {
                            btnTxt += " (waiting for the buyer's agreement)";
                            waitBtnTxt += " (also agree to continue immediately)";
                            riskBtn.addClass('link-disabled');
                        }

                        acceptBtn.text(waitBtnTxt);
                        riskBtn.text(btnTxt);
                    }
                } else if (data.type == 'waiting_accepted') {
                    var statusText = container.find('.deal-comment p'),
                        decision = data.decision,
                        waitTime = 21 - decision.from_creation,
                        comment = "We are waiting for " + waitTime + " " + getDayStr(waitTime) + " to make sure that the channel will not be restored. After this period ";

                    container.find(".admin_transfer-decision-action").remove();

                    if (data.who == 'buyer') {
                        comment += "the seller will have to transfer primary ownership rights.";
                    } else {
                        comment += "you will have to transfer primary ownership rights.";
                    }

                    statusText.text(comment);

                    statusText.after(
                        "<div class='garant-timer-block'>" +
                        "<b>Until the end of the hold:</b>" +
                        "<div class='garant-timer' id='countdown" + data.garant_id + "'></div>" +
                        "</div>"
                    );

                    var myDate = new Date(),
                        setSeconds = Math.round(waitTime * 24 * 3600);

                    myDate.setSeconds(setSeconds);

                    $(".garant-timer#countdown" + data.garant_id).countdown(myDate, function(event) {
                        $(this).html(
                            event.strftime(
                                '<div class="timer-wrapper"><div class="time">%D</div><span class="text">day</span></div><div class="timer-wrapper"><div class="time">%H</div><span class="text">hour</span></div><div class="timer-wrapper"><div class="time">%M</div><span class="text">min</span></div><div class="timer-wrapper"><div class="time">%S</div><span class="text">sec</span></div>'
                            )
                        );
                    });
                } else if (data.type == 'money_sent') {
                    var statusText = container.find('.deal-comment p'),
                        text = null;

                    if (data.who == 'buyer') {
                        var text = null;

                        if (data.social == 'in' || data.social == 'twitter') {
                            text = "the system automatically issues you new details for your account";
                        } else if (data.social == 'youtube') {
                            text = "the escrow agent designates you as the channel owner";
                        } else if (data.social == 'fb') {
                            text = "the escrow agent will transfer administrative rights to you";
                        } else if (data.social == 'tg') {
                            text = "the escrow agent will associate your phone number with the account";
                        }

                        statusText.text("You’ve sent payment to the seller. After the seller’s confirmation, " + text + ". If the seller takes too long to confirm receipt of payment, get in touch the with escrow agent.");
                    } else {
                        statusText.text("The buyer has paid you. After you’ve received payment, please click the confirmation button so that the escrow agent can transfer account access to the buyer.");

                        container.find(".deal-comment").after(
                            "<div class='deal-actions'>" +
                            "<div class='deal-action group'>" +
                            "<div class='deal-action__button group-received-btn' style='margin-left: 0;'>" +
                            "<a href='#' class='orange'>Received payment, transfer account access to the buyer</a>" +
                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                            "</div>" +
                            "</div>" +
                            "</div>"
                        );
                    }
                } else if (data.type == 'money_received') {
                    var statusText = container.find('.deal-comment p');

                    if (data.social == 'youtube') {
                        if (data.who == 'buyer') {
                            statusText.text("The seller has confirmed receipt of payment. The escrow agent will designate your account as the channel’s owner soon.");
                        } else {
                            statusText.text('You’ve confirmed receipt of payment. The escrow agent will designate the buyer’s account as the channel’s owner soon.');
                        }
                    } else if (data.social == 'fb') {
                        if (data.who == 'buyer') {
                            statusText.text("The seller has confirmed receipt of payment. The escrow agent will transfer administrative rights to you soon.");
                        } else {
                            statusText.text("You’ve confirmed receipt of payment. The escrow agent will transfer administrative rights to the buyer soon.");
                        }
                    } else if (data.social == 'tg') {
                        if (data.who == 'buyer') {
                            statusText.text("The seller has confirmed receipt of payment. The escrow agent will associate your phone number with the account soon.");
                        } else {
                            statusText.text('You’ve confirmed receipt of payment. The escrow agent will associate the buyer’s phone number with the account soon.');
                        }
                    }
                } else if (data.type == 'received') {
                    var comment = container.find('.deal-comment'),
                        statusText = comment.find('> p');

                    // gtag_report_conversion(data.conversion_id);

                    if (data.who == 'buyer') {
                        if (data.social == 'in' || data.social == 'twitter') {
                            statusText.after(
                                "<div class='inst-infos-buyed'>" +
                                "<b>" + (data.social == 'in' ? 'Instagram' : 'Twitter') + ":</b>" +
                                "<p>Username: " + data.inst_infos.login + "</p>" +
                                "<p>Password: " + data.inst_infos.pass + "</p>" +
                                "<b>Email:</b>" +
                                "<p>Address: " + data.inst_infos.email + "</p>" +
                                "<p>Password: " + data.inst_infos.email_pass + "</p>" +
                                "</div>"
                            );
                        } else if (data.social == 'tg') {
                            statusText.after(
                                "<div class='inst-infos-buyed'>" +
                                "<b>The creator’s account:</b>" +
                                "<p>Your phone number: <i>" + data.info + "</i></p>" +
                                "</div>"
                            );
                        }
                    } else {
                        container.find(".seller-cancel-deal").remove();
                    }

                    statusText.text("The transaction has been completed successfully! We would be grateful if you could leave a review about your experience.");

                    comment.append(drawReviewForms(data.who));
                    comment.wrap("<div class='deal-actions'></div>");
                } else if (data.type == 'cancel_deal_timer') {
                    var comment = container.find('.deal-comment'),
                        statusText = comment.find('p'),
                        list = comment.closest(".message__list .simplebar-content"),
                        statusMsg = "";

                    if (data.who == 'buyer') {
                        statusMsg = "The transaction has been cancelled. Please confirm that you haven’t yet paid the seller, so that they don’t have to wait for the timer to have their account returned to them. If you have already paid them, please immediately click this button, or in <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> the seller will automatically have their account returned to them. After the transaction’s cancellation, your payment will be refunded to your balance.";

                        statusText.after(
                            "<div class='deal-actions'>" +
                            "<div class='deal-action group'>" +
                            "<div class='deal-action__button confirm-cancel-btn'>" +
                            "<a href='#' class='orange'>Payment has not yet been sent. Return the account to the seller</a>" +
                            "</div>" +
                            "<div class='deal-action__button continue-deal-btn'>" +
                            "<a href='#' class='orange risk-btn'>Payment has already been sent, do not cancel the transaction!</a>" +
                            "</div>" +
                            "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                            "</div>" +
                            "</div>"
                        );
                    } else {
                        container.find(".seller-cancel-deal").remove();
                        container.find(".dont-delete-from-admins").remove();
                        container.find(".wallets-preloader").hide();

                        statusMsg = "The transaction has been cancelled. The buyer has <span class='garant-timer-expire' id='countdown" + data.garant_id + "'></span> to confirm that they have not yet paid you. After this time, you will automatically have your account returned to you.";

                        if (data.cancelled_by == 'seller') {
                            statusText.after(
                                "<button class='orange continue-deal-btn continue-deal-btn-seller'>Continue with the transaction</button>" +
                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Waiting...'>"
                            );
                        }
                    }

                    statusText.html(statusMsg);
                } else if (data.type == 'cancel_deal_confirmation') {
                    var comment = container.find('.deal-comment'),
                        statusText = comment.find('p'),
                        text = "The transaction has been cancelled, ";

                    if (data.who == 'buyer') {
                        text += "and payment has been refunded to your balance.";
                    } else {
                        text += "and payment has been refunded to the buyer. ";
                    }

                    container.find('.garant-save-wallets-form').remove();

                    container.find(".wallets-preloader").hide();
                    container.find(".continue-deal-btn-seller").remove();
                    container.find(".seller-cancel-deal").remove();

                    if (data.who == 'seller' && data.need_return) {
                        if (data.social == 'in' || data.social == 'twitter') {
                            var socialData = data.social == 'in' ? "Instagram" : 'Twitter';

                            statusText.after(
                                "<div class='inst-infos-buyed'>" +
                                "<b>" + socialData + ":</b>" +
                                "<p>Username: " + data.inst_infos.login + "</p>" +
                                "<p>Password: " + data.inst_infos.pass + "</p>" +
                                "<b>Email:</b>" +
                                "<p>Address: " + data.inst_infos.email + "</p>" +
                                "<p>Password: " + data.inst_infos.email_pass + "</p>" +
                                "</div>"
                            );
                        } else {
                            if (data.social == 'tg') {
                                text += "Please provide the phone number you would like to restore the account to.";
                            } else if (data.social == 'youtube') {
                                text += "Please provide the email address of the account to which you’d like to restore ownership rights.";
                            } else if (data.social == 'fb') {
                                text += "Please provide a link to the page to which you would like to restore administrative rights.";
                            }

                            statusText.after(
                                "<div class='deal-actions'>" +
                                "<div class='deal-comment'>" +
                                "<textarea class='instagram-infos' name='instagram-infos' placeholder='Please enter the aforementioned details here'></textarea>" +
                                "</div>" +
                                "</div>" +
                                "<div class='deal-actions'>" +
                                "<div class='deal-action group'>" +
                                "<div class='deal-action__button send-info-to-return-account' style='margin-left: 0'>" +
                                "<a href='#' class='orange'>Send</a>" +
                                "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                                "</div>" +
                                "</div>" +
                                "</div>"
                            );
                        }
                    }

                    statusText.text(text);

                    $(".youtube-transfer-manager-info").remove();
                } else if (data.type == 'reload_dialog') {
                    var dialog = $(".friend.group[data-id='" + data.user_id + "']"),
                        tmpDialog = $(".friend.group[data-id='" + data.tmp_user_id + "']");

                    if (dialog.length) {
                        if (tmpDialog.hasClass('active')) {
                            dialog.addClass('active');
                        }

                        tmpDialog.remove();
                    } else {
                        tmpDialog.attr('data-id', data.user_id)
                            .find(".friend__name")
                            .text(data.nickname);

                        tmpDialog.find(".friend__photo img").attr('src', data.user_img);

                        dialog = tmpDialog;
                    }

                    dialog.find('.friend__noty').text(parseInt(dialog.find('.friend__noty').text()) + 1);
                    dialog.attr('data-noty', 1);

                    dialog.find(".friend__photo").addClass('is');

                    dialog.insertBefore('.friend.group:first');

                    var chatMessages = $(".chat__messages[data-id='" + data.user_id + "']"),
                        chatMessagesTmp = $(".chat__messages[data-id='" + data.tmp_user_id + "']");

                    chatMessages.remove();
                    chatMessagesTmp.remove();

                    loadDialog(dialog);
                } else if (data.type == 'update_return_account_status') {
                    var returnAccount = data.return_account,
                        statusText = container.find('.deal-comment p'),
                        comment = "The transaction has been cancelled, and payment has been refunded to the buyer. ";

                    if (returnAccount.status == 1) {
                        if (data.social == 'tg') {
                            comment += "You’ve given the escrow agent the phone number with which to associate the account. The escrow agent is online from " + garantOnlineFrom + " to " + garantOnlineTo + ". Please make sure to be online during this time to tell them the verification code sent to your number.";
                        } else if (data.social == 'youtube') {
                            comment += "You’ve given the escrow agent the email account for transferral of administrative rights. They will return administrative rights to you soon.";
                        } else if (data.social == 'fb') {
                            comment += "You’ve given the escrow agent a link to the page you want administrative rights transferred to. Soon, they will return administrative rights to you.";
                        }
                    } else if (returnAccount.status == 2) {
                        if (data.social == 'tg') {
                            comment += "The escrow agent has returned your channel to you.";
                        } else if (data.social == 'fb') {
                            comment += "The escrow agent has restored administrative rights to you.";
                        } else if (data.social == 'youtube') {
                            comment += "The escrow agent has assigned your account as owner. You must <a href='https://myaccount.google.com/u/0/brandaccounts?si=1' target='_blank'>accept the invitation</a>. In 7 days they will be able to designate you as the primary owner or you can do that by yourself (7 days is the minimum amount of waiting time required in order to assign a new person as the primary owner in the control panel).";
                        }
                    } else if (returnAccount.status == 4) {
                        if (data.social == 'youtube') {
                            comment += "The escrow agent has returned to you primary ownership rights.";
                        }
                    }

                    statusText.html(comment);
                } else if (data.type == 'already_paid') {
                    container.find('.deal-comment p').text("Someone has already paid for this page.");
                    container.find('.deal-actions:not(:last):not(:first)').remove();
                }

                var myDate = new Date(),
                    hours = (data.social == 'vk' && data.type == 'new_inst_infos') ? 12 : 24;

                if (data.type == 'cancel_deal_timer') hours = 3;

                myDate.setSeconds(Math.round(hours * 3600));

                $(".garant-timer-expire#countdown" + data.garant_id).countdown(myDate, function(event) {
                    $(this).html(
                        event.strftime('%H:%M:%S')
                    );
                });

                if (data.type != 'reload_dialog') {
                    container.find("select").select2({
                        minimumResultsForSearch: -1
                    });

                    setGarantEvent(data.garant_event, data.user_id, true);

                    if (data.noty_count) {
                        var dialog = $(".friend.group[data-id='" + data.user_id + "']"),
                            list = $(".chat__messages[data-id='" + data.user_id + "']  .message__list .simplebar-content-wrapper");

                        dialog.find(".friend__noty").text(data.noty_count);
                        dialog.attr('data-noty', 1);

                        if (list.is(':visible')) {
                            list.animate({
                                scrollTop: list[0].scrollHeight
                            }, 0);

                            chatRead();
                            garantEventRead();
                        }

                        if (data.all_noty) {
                            $(".chat-button1 span").text(data.all_noty);
                            $(".chat-button1 span").show();
                        }
                    }
                }
            });
        </script>
        <script>
            $("body").on('change', ".deal-action__select select", function() {
                var transfer = $(this).val(),
                    container = $(this).closest(".deal-actions"),
                    input = container.find(".transfer-info-input"),
                    last = input.attr('data-transfer'),
                    first = $(this).attr('data-first'),
                    button = container.find(".accept-condition-btn");

                input.attr('data-transfer', transfer);

                if (transfer == 0) {
                    input.attr('placeholder', "Phone number to associate with Telegram account");
                    input.val("");
                } else if (last == 0) {
                    input.attr('placeholder', "Page you want to transfer rights to");
                    input.val("");
                }

                if (first == transfer) {
                    button.show();
                } else {
                    button.hide();
                }

                if (first == transfer || (transfer > 0 && first > 0)) {
                    input.val(input.attr('data-info'));
                }
            });

            $('#chat1').on('click', '.accept-condition-btn a', function(e) {
                e.preventDefault();

                var container = $(this).closest('.garant-container'),
                    input = container.find(".transfer-info-input"),
                    button = $(this),
                    garantId = container.attr('data-id'),
                    preloader = $(this).next(),
                    info = '';

                if (input.length) {
                    var transfer = input.attr('data-first'),
                        social = container.attr('data-social');

                    info = input.val();

                    if (validateInfoField(transfer, input, info, social) == 'stop') {
                        return false;
                    }
                }

                if (!button.attr('data-terms')) {
                    var modal = $('#policy-modal');

                    modal.find(".garant-terms-warning").hide();
                    if (social == 'tg' || $(this).attr('data-who') != 'buyer') {
                        modal.find(".policy-container").css("height", '74vh');
                    } else {
                        modal.find(".garant-terms-warning").show();
                        modal.find(".policy-container").css("height", '65vh');
                    }

                    modal.find(".policy-container > div").hide();
                    modal.find(".garant-terms-text").show();
                    modal.find("button").attr('data-type', 'accept-condition').attr('data-id', container.attr('data-id')).text("I have read and agree to the terms and conditions");
                    modal.modal('show');

                    return false;
                }

                button.hide();
                preloader.show();

                $.ajax({
                        url: "/garant/accept",
                        data: {
                            info: info,
                            garant_id: garantId,
                            _token: csrf
                        },
                        method: 'POST'
                    })
                    .always(function() {
                        preloader.hide();
                        button.show();
                        container.find(".chat-payment-methods").remove();
                    })
                    .done(function(data) {

                        if (data[0] == 'error') {
                            setNoty(data[1], 'error');
                        } else {
                            container.find('> .deal-actions > .deal-action').remove();
                            container.find(".transfer-info-input").remove();

                            if (data.who == 'buyer') {
                                container.find('.deal-comment p').text("The terms of the transaction were confirmed. When you send your payment, the seller will be notified, and will need to transfer the account login details based on the agreed upon terms. If the seller does not respond, or breaks the rules, you can call upon the escrow agent (button below).");
                                container.find('.deal-comment').after(drawChatPaymentMethods(data.amount, data.discount, 'buyer'));

                                setNoty('The terms of the transaction have been confirmed, awaiting payment.', 'success');
                            } else if (data.who == 'seller') {
                                container.find('.deal-comment p').text("The terms of the transaction were confirmed, awaiting payment. Do not transfer the account directly! Follow the instructions on this page once the buyer has paid.");
                                container.find('.deal-comment').after(drawChatPaymentMethods(data.amount, data.discount, 'seller'));

                                setNoty('The terms of the transaction have been confirmed, please wait for payment from the buyer.', 'success');
                            }

                            container.find(".deal-action__select:last select").select2({
                                minimumResultsForSearch: -1
                            });
                        }

                    }).fail(function() {
                        unknowError();
                    });
            });

            $("body").on('click', '.garant-transferred-btn a', function(e) {
                e.preventDefault();

                var container = $(this).closest('.garant-container'),
                    instInfos = container.find('.instagram-infos').length ? container.find('.instagram-infos').val() : '',
                    button = $(this),
                    preloader = $(this).closest(".garant-transferred-btn").find(".wallets-preloader");

                button.hide();
                preloader.show();

                $.ajax({
                    url: "/garant/transferred",
                    data: {
                        garant_id: container.attr('data-id'),
                        inst_infos: instInfos,
                        _token: csrf
                    },
                    method: 'POST'
                }).fail(function() {
                    preloader.hide();
                    button.show();
                }).done(function(data) {
                    if (data[0] == 'error') {
                        setNoty(data[1], 'error');
                        preloader.hide();
                        button.show();
                    }
                }).fail(function() {
                    unknowError();
                });
            });

            $("body").on('click', '.group-received-btn a', function(e) {
                e.preventDefault();

                var modal = $("#confirm-garant-modal");

                modal.attr('data-id', $(this).closest('.garant-container').attr('data-id')).attr('data-type', 'confirm');
                modal.find(".modal-block__title").text("Confirmation of receipt of payment");
                modal.find(".modal-block__desc p").text("Please verify that you have received payment. If everything is as expected, please confirm, and the account will be transferred to the buyer.");
                modal.modal('show');
            });

            $("body").on('click', '.seller-cancel-deal', function(e) {
                e.preventDefault();

                var modal = $("#confirm-garant-modal");

                modal.attr('data-id', $(this).closest('.garant-container').attr('data-id')).attr('data-type', 'cancel');
                modal.find(".modal-block__title").text("Are you sure you want to cancel the transaction?");
                modal.find(".modal-block__desc p").text("After cancellation, the commission will be refunded to the buyer. The escrow agent will return your account to you (if you’ve already transferred it).");
                modal.modal('show');
            });

            $("body").on('click', '#confirm-garant-modal .orange', function(e) {
                e.preventDefault();
                var modal = $("#confirm-garant-modal"),
                    garantId = modal.attr('data-id'),
                    type = $("#confirm-garant-modal").attr('data-type');

                if (type == 'confirm') {
                    receivedAction(garantId);
                } else if (type == 'cancel') {
                    cancelAction(garantId);
                }

                modal.modal('hide');
            });

            function receivedAction(garantId) {
                var container = $('.garant-container[data-id="' + garantId + '"]'),
                    button = container.find(".group-received-btn a"),
                    preloader = button.next();

                button.hide();
                preloader.show();

                $.ajax({
                    url: "/garant/received",
                    data: {
                        garant_id: garantId,
                        _token: csrf
                    },
                    method: 'POST'
                }).done(function(data) {
                    if (data[0] == 'error') {
                        setNoty(data[1], 'error');
                        button.hide();
                        preloader.show();
                    }
                }).fail(function() {
                    preloader.hide();
                    button.show();
                    unknowError();
                });
            }

            $("body").on('click', '.money-sent-to-seller-btn a', function() {
                var btn = $(this),
                    preloader = btn.next(),
                    container = btn.closest(".garant-container"),
                    garantId = container.attr('data-id');

                btn.hide();
                preloader.show();

                $.ajax({
                    url: '/garant/money_sent',
                    method: 'POST',
                    data: {
                        id: garantId,
                        _token: csrf
                    }
                }).done(function(data) {
                    if (data[0] == 'error') {
                        setNoty(data[1], 'error');
                        btn.hide();
                        preloader.show();
                    }
                }).fail(function() {
                    unknowError();
                    preloader.hide();
                    btn.show();
                });
            });

            function cancelAction(garantId) {
                var container = $(".garant-container[data-id='" + garantId + "']"),
                    btn = container.find(".seller-cancel-deal"),
                    preloader = btn.next();

                btn.hide();
                preloader.show();

                $.ajax({
                        url: '/cancel_deal',
                        method: 'POST',
                        data: {
                            id: container.attr('data-id'),
                            _token: csrf
                        }
                    })
                    .fail(function() {
                        preloader.hide();
                        btn.show();
                        unknowError();
                    });
            }

            function completeGarantAction(container) {
                var toId = container.closest('.chat__messages').attr('data-id'),
                    garantId = container.attr('data-id'),
                    garantsBarOpen = $(".open-garants-bar[data-id='" + toId + "']");

                garantsBarOpen.find("img:first-child").css('margin-left', '5px');
                garantsBarOpen.find("img:nth-child(2)").show();
                garantsBarOpen.find("img:last-child").hide().css('margin-left', '6px');

                $(".garants-bar li[data-id='" + garantId + "'] .garant-bar-event").remove();
                $(".garant-msg-alert[data-type='new-event'][data-id='" + garantId + "']").remove();

                if (!$(".garants-bar[data-id='" + toId + "'] li .garant-bar-event").length) {
                    $(".friend.group[data-id='" + toId + "']").attr('data-event', 0);
                }

                if (!$("#chat1 .dialog-alarm-bell:visible").length) {
                    $("#all-chat-alarm-bell").hide();
                }
            }

            $("body").on('submit', '.give-service-review_form', function(e) {
                e.preventDefault;

                var garantId = $(this).closest('.garant-container').attr('data-id'),
                    review = $(this).find('textarea');

                $.ajax({
                    url: "/garant/review",
                    data: {
                        type: 'service',
                        garant_id: garantId,
                        review: review.val(),
                        _token: csrf
                    },
                    method: 'POST'
                }).done(function() {
                    setNoty('Thank you for your review!', 'success');
                    review.attr('disabled', 'disabled').css('background', 'gainsboro');
                    review.next().remove();
                });

                return false;
            });

            $("body").on('submit', '.give-user-review_form', function(e) {
                e.preventDefault;

                var form = $(this),
                    garantId = $(this).closest('.garant-container').attr('data-id'),
                    review = $(this).find('textarea'),
                    type = $(this).find('select').val();

                if (review.val()) {
                    $.ajax({
                        url: "/garant/review",
                        data: {
                            type: 'user',
                            garant_id: garantId,
                            review: review.val(),
                            review_type: type,
                            _token: csrf
                        },
                        method: 'POST'
                    }).done(function(data) {
                        if (data[0] == 'auth_error') {
                            setNoty(data[1] + ' has to register or log in for you to be able to leave them a review.', 'error');
                        } else {
                            setNoty('Thank you for your review!', 'success');
                            review.attr('disabled', 'disabled');
                            form.find('button').remove();
                            form.find(".deal-comment__select").remove();

                            var styles = {};

                            if (type == 1) {
                                styles['background-color'] = '#60D260';
                                styles['border-color'] = 'green';
                                styles['color'] = 'white';
                            } else if (type == 2) {
                                styles['background-color'] = '#d3d3d3';
                            } else if (type == 3) {
                                styles['background-color'] = '#FF7474';
                                styles['color'] = 'white';
                            }

                            review.css(styles)
                                .after("<button class='change-review-btn'>Change review</button>");
                        }
                    });
                } else {
                    setNoty('Please write something in the review text', 'error');
                }

                return false;
            });
        </script>
        <script>
            var typing = false,
                timeout = undefined,
                myId = 1490768728;

            $('#chat1').on('keydown', '.chat__messages textarea', function() {
                var toId = $(this).closest('.chat__messages').attr('data-id'),
                    text = $(this).val();

                if (text.length == 1) {
                    $(this).val(text.toUpperCase());
                }

                if (typing == false) {
                    typing = true;
                    socket.emit('typing', {
                        type: 'start',
                        to: toId,
                        from: myId,
                        token_to_id: toId
                    });
                    timeout = setTimeout(function() {
                        typing = false;
                        socket.emit('typing', {
                            type: 'stop',
                            to: toId,
                            from: myId,
                            token_to_id: toId
                        });
                    }, 4000);
                } else {
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        typing = false;
                        socket.emit('typing', {
                            type: 'stop',
                            to: toId,
                            from: myId,
                            token_to_id: toId
                        });
                    }, 4000);
                }
            });

            socket.on('typing', function(data) {
                var typing = $(".chat__messages[data-id='" + data.from + "'] .message.mine.group.typing"),
                    list = typing.closest(".message__list .simplebar-content-wrapper"),
                    scrollDown = false;

                if (list.is(':visible')) {
                    var lastMessage = list.find(".message:not(.typing):last");

                    if (lastMessage.length && isIntoView(lastMessage)) {
                        scrollDown = true;
                    }
                }

                if (data.type == 'start') {
                    typing.slideDown(400, function() {
                        if (scrollDown)
                            list.scrollTop(list[0].scrollHeight);
                    });
                } else if (data.type == 'stop') {
                    typing.slideUp(400, function() {
                        if (scrollDown)
                            list.scrollTop(list[0].scrollHeight);
                    });
                }
            });

            socket.on('donate_before_paid', function(data) {
                window.location.replace("login.html");
            });

            function createDialogChat(submitBtn, msg_register) {
                if (submitBtn) {
                    var userId = submitBtn.attr('data-user-id'),
                        dialog = $(".friend.group[data-id='" + userId + "']");
                } else {
                    var dialog = "",
                        user = msg_register;
                }

                if (dialog.length) {
                    var list = $(".chat__messages[data-id='" + userId + "']");

                    if (list.length) {
                        var profile = $(".chat-user[data-id='" + userId + "']")

                        $(".chat__messages").hide();
                        $(".chat-user").hide();
                        $(".friend.group").removeClass('active');

                        dialog.addClass('active');

                        dialog.show();
                        list.show();
                        profile.show();

                        focusTextArea();
                    } else {
                        return loadDialog(dialog);
                    }
                } else {
                    if (submitBtn) {
                        $(".chat__messages:visible").css('opacity', 0.25);
                        $(".chat-user:visible").css('opacity', 0.25);
                        $(".open-garants-bar:visible").css('opacity', 0.25);
                        $(".garants-bar:visible").css('opacity', 0.25);
                        $("#dialog-preloader").show();

                        var user = null,
                            online = null,
                            active = null,
                            contacts = null,
                            groups = null,
                            img = null,
                            reviews = null,
                            userBadgesHtml = '';

                        return $.ajax({
                            url: '/chat/get/user_infos',
                            method: 'POST',
                            data: {
                                user_id: userId,
                                _token: csrf
                            }
                        }).always(function() {
                            $("#dialog-preloader").hide();
                        }).done(function(data) {
                            user = data.user;
                            online = data.online;
                            active = data.active;
                            contacts = data.contacts;
                            groups = data.groups;
                            img = user.img_path;
                            reviews = data.reviews;
                            userBadgesHtml = data.userBadges_html;

                            drawDialog(user, msg_register, online, active, contacts, groups, img, reviews, userBadgesHtml, data.chat_id);

                        }).fail(function() {
                            unknowError();
                        });
                    } else {
                        drawDialog(user, msg_register);
                    }
                }
            }

            function focusTextArea() {
                var el = $('.message__list:visible .simplebar-content-wrapper');

                if ($(window).width() > 991)
                    el.closest('.chat__messages').find('.messages-form textarea').focus();

                el.scrollTop(el[0].scrollHeight);
            }

            function drawDialog(user, msg_register, online, active, contacts, groups, img, reviews, userBadgesHtml, chatId) {
                if (img == null) {
                    img = 'images/profile.png';
                }

                var is_online = "",
                    last_active = "",
                    is_active = "";

                if (online) {
                    is_online = "style='display: block;'";
                    is_active = 'is';
                } else {
                    last_active = "style='display: block;'";
                }

                $('.chat__friends .simplebar-content').prepend(
                    "<div class='friend group' data-chat_id='" + chatId + "' data-id='" + user.id + "'>" +
                    "<div class='friend__photo " + is_active + "'>" +
                    "<img src='" + img + "' class='img-responsive img-circle'>" +
                    "</div>" +
                    "<div class='friend__data'>" +
                    "<p class='friend__name'>" + user.nickname + "</p>" +
                    "<p></p>" +
                    "</div>" +
                    "<div class='friend__time'></div>" +
                    "<span class='friend__noty'>0</span>" +
                    "</div>"
                );

                if ($(".friend.group").length >= 22) {
                    $.when(loadDialog($(".friend.group:first"))).done(function(data) {
                        if (data == 'empty') {
                            drawChat(user, msg_register, online, active, contacts, groups, img, reviews, last_active, is_online, userBadgesHtml, chatId);
                        }
                    });
                } else {
                    drawChat(user, msg_register, online, active, contacts, groups, img, reviews, last_active, is_online, userBadgesHtml, chatId);
                }
            }

            function drawChat(user, msg_register, online, active, contacts, groups, img, reviews, last_active, is_online, userBadgesHtml, chatId) {
                $('.chat__friends:last').after(
                    "<div class='chat__messages' data-chat='" + chatId + "' data-id='" + user.id + "'>" +
                    "<div class='dialog-alerts-container'>" +
                    ((msg_register && user.nickname != 'Unknown') ?
                        "<p class='garant-msg-alert' data-type='register'>We recommend you <a href='#modal1' id='js-modal1' data-toggle='modal'>register</a> so that you don’t lose this message history." +
                        "<i class='fa fa-times' data-id='" + msg_register.id + "'></i>" +
                        "</p>" : "") +
                    "</div>" +
                    "<div class='messages-form'>" +
                    "<form>" +
                    "<textarea name='text' placeholder='Enter your message'></textarea>" +
                    "<img id='attach-files' src='/images/paperclip.png' alt='Attach'>" +
                    "<button type='submit' data-to='" + user.id + "'></button>" +
                    "</form>" +
                    "</div>" +
                    "<div class='message__list'>" +
                    "<div class='message mine group typing'>" +
                    "<div class='message__photo'>" +
                    "<img src='/images/seller.png' class='img-responsive img-circle'>" +
                    "<time datetime></time>" +
                    "</div>" +
                    "<div class='message__text'>" +
                    "<div class='inner'>" +
                    "<span>·</span>" +
                    "<span>·</span>" +
                    "<span>·</span>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );

                new SimpleBar($(".chat__messages[data-id='" + user.id + "'] .message__list")[0]);

                var userInfo = "",
                    onlineString = "",
                    userNickname = "<a href='#'>Unknown</a>",
                    profileImg = "<img src='" + img + "' class='img-responsive center-block img-circle'>";


                var garantOnline = true;

                var garantsBar =
                    "<div data-id='" + user.id + "' class='open-garants-bar open-garants-bar-user'>" +
                    "<img src='/images/garant-arrow.png'>" +
                    "<img src='/images/handshake.png'>" +
                    "<img src='/images/alarm-bell-symbol.png'>" +
                    "</div>" +
                    "<div data-id='" + user.id + "' class='garants-bar'>" +
                    "<b>List of transactions with this user</b>" +
                    "<p>You don’t yet have any transactions with this user.</p>" +
                    "<div class='garant-bar-buttons'>" +
                    "<a href='#' class='orange'>Contact the escrow agent</a>" +
                    "<img class='wallets-preloader' src='/images/chat_preloader.gif' alt='Saving...'>" +
                    "<span style='" + (!garantOnline ? "display: none;" : "") + "' class='garant-online-yes-span'> — Online (" + garantOnlineFrom + " - " + garantOnlineTo + ")</span>" +
                    "<span style='" + (garantOnline ? "display: none;" : "") + "' class='garant-online-no-span'> — Online " + garantOnlineFrom + " - " + garantOnlineTo + "</span>" +
                    "</div>" +
                    "</div>";

                if (user.nickname != 'Unknown') {
                    var addGroups = '',
                        addContacts =
                        "<tr>" +
                        "<td>E-mail:</td>" +
                        "<td>" + ((contacts && contacts.show_email) ? user.email : "hidden") + "</td>" +
                        "</tr>";

                    if (contacts) {
                        addContacts =
                            "<tr>" +
                            "<td>Name:</td>" +
                            "<td>" + (contacts.fio ? contacts.fio : "not provided") + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Phone number:</td>" +
                            "<td>" + (contacts.phone ? contacts.phone : "not provided") + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Skype:</td>" +
                            "<td>" + (contacts.skype ? contacts.skype : "not provided") + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>Telegram:</td>" +
                            "<td>" + (contacts.tg ? contacts.tg : "not provided") + "</td>" +
                            "</tr>" +
                            "<tr>" +
                            "<td>FB:</td>" +
                            "<td>" + (contacts.fb ? contacts.fb : "not provided") + "</td>" +
                            "</tr>";
                    }

                    if (groups) {
                        $.each(groups, function(index, value) {
                            addGroups +=
                                "<div class='user-post'>" +
                                "<p class='user-post__title'>" +
                                "<a href='/group/" + value.id + "'>" + value.name + "</a>" +
                                "</p>" +
                                "<p>Subscribers: " + value.subscribers + "<br>Price: $" + value.price + "</p>" +
                                "</div>"
                        });
                    } else {
                        addGroups = "<p class='chat-no-groups'>This user has no listings.</p>";
                    }

                    userInfo =
                        "<div class='chat-user__rating text-center'>" +
                        "<div class='rate'>Rating: " + user.rating1 + "</div>" +
                        "<div class='reviews'>" +
                        "<a href='/profile/" + user.real_nickname + "' class='plus'>" + reviews.plus + "</a>" +
                        "<a href='/profile/" + user.real_nickname + "' class='middle'>" + reviews.middle + "</a>" +
                        "<a href='/profile/" + user.real_nickname + "' class='minus'>" + reviews.minus + "</a>" +
                        "</div>" +
                        userBadgesHtml +
                        "</div>" +
                        "<div class='chat-user__info'>" +
                        "<table>" +
                        "<tbody>" +
                        addContacts +
                        "</tbody>" +
                        "</table>" +
                        "</div>" +
                        "<div class='chat-user__posts'>" +
                        "<p class='title'>Listings:</p>" +
                        addGroups +
                        "</div>";

                    onlineString =
                        "<p class='last-active-p' " + last_active + ">Last online " + active + "</p>" +
                        "<div class='chat-user__state in' " + is_online + ">Online</div>";

                    profileImg =
                        "<a href='/profile/" + user.real_nickname + "'>" +
                        "<img src='" + img + "' class='img-responsive center-block img-circle'>" +
                        "</a>";

                    userNickname = "<a href='/profile/" + user.real_nickname + "'>" + user.nickname + "</a>";
                }

                $(".chat__messages:last").after(
                    "<div class='chat-user' data-id='" + user.id + "'>" +
                    "<div class='chat-user__info-data'>" +
                    "<div class='chat-user__photo'>" +
                    profileImg +
                    "</div>" +
                    "<div class='chat-user__name'>" +
                    userNickname +
                    "</div>" +
                    onlineString +
                    userInfo +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    garantsBar
                );

                new SimpleBar($(".chat-user[data-id='" + user.id + "']")[0]);

                $('.chat-user[data-id="' + user.id + '"] [data-toggle="tooltip"]').tooltip();

                $(".friend.group").removeClass('active');
                $(".friend.group[data-id='" + user.id + "']").addClass('active');

                $(".chat__messages").hide();
                $(".chat__messages[data-id='" + user.id + "']").show();

                $(".chat-user").hide();
                $(".chat-user[data-id='" + user.id + "']").show();

                focusTextArea();
            }

            $(".right-top__connect a, #write-user").on('click', function(e) {
                e.preventDefault();

                var button = $(this);

                $.when(loadDialogs('start')).done(function() {
                    createDialogChat(button);
                });
            });

            $("body").on('click', '.garant-msg-alert i', function() {
                var id = $(this).attr('data-id'),
                    container = $(this).parent();

                container.fadeOut(400, function() {
                    adjustMessageListHeight();
                });

                $.ajax({
                    url: '/chat/alert/remove',
                    method: 'POST',
                    data: {
                        id: id,
                        _token: csrf
                    }
                }).fail(function() {
                    unknowError();
                });
            });

            $("body").on('click', '.garants-bar li', function() {
                loadMessagesToGarantOrMsg($(this).attr('data-id'));
                $(".garants-bar").hide();
                $('.open-garants-bar:visible img:first-child').toggleClass("rotated");
            });

            $("body").on('click', ".garant-msg-alert[data-type='new-event']", function() {
                loadMessagesToGarantOrMsg($(this).attr('data-id'), null, 600);
            });

            $("#mobile-show-dialogs").on('click', function() {
                $('.chat__messages').hide();
                $('.chat-user').hide();
                $(".open-garants-bar").hide();
                $(".garants-bar").hide();
                $(".open-garants-bar img:first-child").removeClass('rotated');
            });

            $("#mobile-show-dialog").on('click', function() {
                var id = $(".friend.group.active").attr('data-id');
                $(".chat__messages[data-id='" + id + "']").css("cssText", "display: block!important;");
                $('.chat-user').hide();
                $(".open-garants-bar[data-id='" + id + "']").show();
                adjustMessageListHeight();
            });

            $("#mobile-show-profile").on('click', function() {
                var id = $(".friend.group.active").attr('data-id');
                $('.chat__messages').hide();
                $(".chat-user[data-id='" + id + "']").css("cssText", "display: block!important;");
                $(".open-garants-bar").hide();
                $(".garants-bar").hide();
                $(".open-garants-bar img:first-child").removeClass('rotated');
            });

            $("body").on('click', '.change-review-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                form.attr('class', "group give-user-review_form")
                    .find('textarea').attr('name', 'user_review').removeAttr('disabled').removeAttr('style')
                    .after(
                        "<div class='deal-comment__select'>" +
                        "<select name='user_review_type' style='width: 100%'>" +
                        "<option value='1'>Positive</option>" +
                        "<option value='2'>Neutral</option>" +
                        "<option value='3'>Negative</option>" +
                        "</select>" +
                        "</div>"
                    )
                    .next().next().attr('type', 'submit').text("Save").removeAttr('class');

                $(".deal-comment__select select").select2({
                    minimumResultsForSearch: -1
                });
            });

            $(window).on('resize', function() {
                adjustMessageListHeight();
                adjustAdminDialogHeight();
            });
        </script>
        <script>
            $(document).ready(function() {
                adjustAdminDialogHeight();
            });

            function adjustAdminDialogHeight() {
                var screenWidth = $(window).width(),
                    adminDialog = $(".friend.group[data-id='admin']");

                if (screenWidth < 768) {
                    adminDialog.css('top', $(window).height() - 66);
                } else if (screenWidth >= 768 && screenWidth < 992) {
                    adminDialog.hide();
                } else {
                    adminDialog.removeAttr('style');
                }
            }

            $(".qiwi-dont-have-transaction").on('click', function(e) {
                e.preventDefault();
                $("#qiwi-comment-forgot-modal").modal('hide');
                $("#qiwi-dont-have-transaction-modal").modal('show');
            });
        </script>
    </section>
    @include('partials.footer')
    @include('partials.model-containers')

    <!-- <form id="hidden-payment-form" target="_blank" style="display: none;"></form>
    <form id="payeer-form" method="post" action="https://payeer.com/merchant/" target="_blank">
        <input type="hidden" name="m_shop" value="1175614867">
        <input type="hidden" name="m_orderid">
        <input type="hidden" name="m_amount">
        <input type="hidden" name="m_curr">
        <input type="hidden" name="m_desc">
        <input type="hidden" name="m_sign">
        <input type="hidden" name="lang" value="en">
      
    </form>
    <form id="advcash-form" method="POST" action="https://wallet.advcash.com/sci/">
        <input type="hidden" name="ac_account_email" value="info@trade-groups.ru">
        <input type="hidden" name="ac_sci_name">
        <input type="hidden" name="ac_amount">
        <input type="hidden" name="ac_currency">
        <input type="hidden" name="ac_order_id">
        <input type="hidden" name="ac_sign">
        <input type="hidden" name="ac_comments">
    </form>
    <form id="enot-form" method='POST' action='https://enot.io/pay'>
        <input type='hidden' name='m' value='36447'>
        <input type='hidden' name='oa'>
        <input type='hidden' name='o'>
        <input type='hidden' name='s'>
        <input type='hidden' name='p'>
        <input type='hidden' name='cr' value="USD">
    </form>
    <form id="interkassa-form" method="post" action="https://sci.interkassa.com/" accept-charset="UTF-8">
        <input type="hidden" name="ik_co_id">
        <input type="hidden" name="ik_pm_no">
        <input type="hidden" name="ik_am">
        <input type="hidden" name="ik_cur">
        <input type="hidden" name="ik_desc">
        <input type="hidden" name="ik_sign">
    </form> -->


   
@include('partials.scripts')



</body>

<!-- Mirrored from accs-market.com/youtube by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 18 Oct 2022 16:18:25 GMT -->

</html>