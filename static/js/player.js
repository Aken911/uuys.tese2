var MacPlayer = {
    'GetUrl': function(s, n) {
        return this.Link.replace('{sid}', s).replace('{sid}', s).replace('{nid}', n).replace('{nid}', n)
    },
    'Go': function(s, n) {
        location.href = this.GetUrl(s, n)
    },
    'Show': function() {
        $('#buffer').attr('src', this.Prestrain);
        setTimeout(function() {
            MacPlayer.AdsEnd()
        }, this.Second * 1000);
        $("#playleft").get(0).innerHTML = this.Html + '';
        var a = document.createElement('script');
        a.type = 'text/javascript';
        a.async = true;
        a.charset = 'utf-8';
        a.src = '';
        var b = document.getElementsByTagName('script')[0];
        b.parentNode.insertBefore(a, b)
    },
    'AdsStart': function() {
        if ($("#buffer").attr('src') != this.Buffer) {
            $("#buffer").attr('src', this.Buffer)
        }
        $("#buffer").show()
    },
    'AdsEnd': function() {
        $('#buffer').hide()
    },
    'Install': function() {
        this.Status = false;
        $('#install').show()
    },
    'Play': function() {
        document.write('<style>.MacPlayer{background: #000000;font-size:14px;color:#F6F6F6;margin:0px;padding:0px;position:relative;overflow:hidden;width:100%;height:100%;min-heigh:300px;}.MacPlayer table{width:100%;height:100%;}.MacPlayer #playleft{position:inherit;!important;width:100%;height:100%;}</style><div class="MacPlayer">' + '<iframe id="buffer" src="" frameBorder="0" scrolling="no" width="100%" height="100%" style="position:absolute;z-index:99998;"></iframe><iframe id="install" src="" frameBorder="0" scrolling="no" width="100%" height="100%" style="position:absolute;z-index:99998;display:none;"></iframe>' + '<table border="0" cellpadding="0" cellspacing="0"><tr><td id="playleft" valign="top" style=""> </td></table></div>');
        this.Height = $('.MacPlayer').get(0).offsetHeight;
        this.Width = $('.MacPlayer').get(0).offsetWidth;
        document.write('<scr' + 'ipt src="' + this.Path + this.PlayFrom + '.js"></scr' + 'ipt>')
    },
    'Down': function() {},
    'Init': function() {
        this.Status = true;
        this.Parse = '';
        if (player_aaaa.encrypt == '1') {
            player_aaaa.url = unescape(player_aaaa.url);
            player_aaaa.url_next = unescape(player_aaaa.url_next)
        } else if (player_aaaa.encrypt == '2') {
            player_aaaa.url = unescape(base64decode(player_aaaa.url));
            player_aaaa.url_next = unescape(base64decode(player_aaaa.url_next))
        }
        this.Prestrain = MacPlayerConfig.prestrain;
        this.Buffer = MacPlayerConfig.buffer;
        this.Second = MacPlayerConfig.second;
        this.Flag = player_aaaa.flag;
        this.Trysee = player_aaaa.trysee;
        this.Points = player_aaaa.points;
        this.Link = decodeURIComponent(player_aaaa.link);
        this.PlayFrom = player_aaaa.from;
        this.PlayNote = player_aaaa.note;
        this.PlayServer = player_aaaa.server == 'no' ? '' : player_aaaa.server;
        this.PlayUrl = player_aaaa.url;
        this.PlayUrlNext = player_aaaa.url_next;
        this.PlayLinkNext = player_aaaa.link_next;
        this.PlayLinkPre = player_aaaa.link_pre;
		this.Poster = player_aaaa.poster;
		this.UserId = player_aaaa.user_id;
		this.GroupId = player_aaaa.group_id;
		this.AdsStatus = player_aaaa.ads_status;
		this.AdsVip = player_aaaa.ads_vip;
		this.AdsGroup = player_aaaa.ads_group;
		this.LogoStatus = player_aaaa.logo_status;
		this.LogoPic = player_aaaa.logo_pic;
		this.LogoLink = player_aaaa.logo_link;
		this.CopyrStatus = player_aaaa.copyr_status;
		this.CopyrContent = player_aaaa.copyr_content;
		this.CopyrLink = player_aaaa.copyr_link;
		this.ArtAuto = player_aaaa.art_auto;
		this.ThemeColor = player_aaaa.theme_color;
		this.PreAdsStatus = player_aaaa.pre_ads_status;
		this.PreAdsMode = player_aaaa.pre_ads_mode;
		this.PreAdsTime = player_aaaa.pre_ads_time;
		this.PreAdsButton = player_aaaa.pre_ads_button;
		this.PreAdsAuth = player_aaaa.pre_ads_auth;
		this.PreAdsGroup = player_aaaa.pre_ads_group;
		this.PrePicImg = player_aaaa.pre_pic_img;
		this.PrePicLink = player_aaaa.pre_pic_link;
		this.PreVodUrl = player_aaaa.pre_vod_url;
		this.PreVodLink = player_aaaa.pre_vod_link;
		this.PauseStatus = player_aaaa.pause_status;
		this.PausePic = player_aaaa.pause_pic;
		this.PauseLink = player_aaaa.pause_link;
        if (MacPlayerConfig.server_list[this.PlayServer] != undefined) {
            this.PlayServer = MacPlayerConfig.server_list[this.PlayServer].des
        }
        if (MacPlayerConfig.player_list[this.PlayFrom] != undefined) {
            if (MacPlayerConfig.player_list[this.PlayFrom].ps == "1") {
                this.Parse = MacPlayerConfig.player_list[this.PlayFrom].parse == '' ? MacPlayerConfig.parse : MacPlayerConfig.player_list[this.PlayFrom].parse;
                this.PlayFrom = 'parse'
            }
        }
        this.Path = maccms.path + '/static/player/';
        if (this.Flag == "down") {
            MacPlayer.Down()
        } else {
            MacPlayer.Play()
        }
    }
};
MacPlayer.Init();