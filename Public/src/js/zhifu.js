//支付的js
(function(window) {
	var pay = function pay(price, ordersid, phpurl, type) {
		console.log(price +'   '+ ordersid+'   '+phpurl+'  '+type)
		this.price = price;
		this.ordersid = ordersid;
		this.phpurl = phpurl;
		this.type = type;
		//判断是充值还是供养 1为购买小说， 2 为充值
//		alert(this.type);alert(this.phpurl);
	}
	//支付宝支付
	pay.prototype.zhifubao = function( callback) {
		var obj = api.require('aliPay');
		var subject = ZhiFuConfig.subject;
		var body = ZhiFuConfig.body;
//		alert(this.type);
		var notifyURL = this.phpurl + 'pay/notify_url.php?type='+this.type;
		var types =  this.type;
		var phpurl = this.phpurl;
		//支付异步通知借口（前端勿管）
		var price = this.price;
		var ordersid = this.ordersid;
		
		obj.config({
			partner : ZhiFuConfig.partner, //
			seller : ZhiFuConfig.seller, //
			rsaPriKey : ZhiFuConfig.rsaPriKey, //
			rsaPubKey : ZhiFuConfig.rsaPubKey, //
			notifyURL : notifyURL//
		}, function(ret, err) {
			console.log($api.jsonToStr(ret));
			console.log($api.jsonToStr(err));
		});
		
//		alert($api.jsonToStr({
//			subject : subject,
//			body : body,
//			amount : price,
//			tradeNO : ordersid
//		}))


		obj.pay({
			subject : subject,
			body : body,
			amount : price,
			tradeNO : ordersid
		}, function(ret, err) {
			if (ret.code == 9000) {
				callback && callback(true);
			}  else if (ret.code == 4000) {
                alert('系统异常,错误码:4000')
                callback && callback(false)
            } else if (ret.code == 4001) {
                alert('数据格式不正确,错误码:4001')
                callback && callback(false)
            } else if (ret.code == 4003) {
                alert('支付宝账户被冻结或不允许支付,错误码:4003')
                callback && callback(false)
            } else if (ret.code == 4003) {
                alert('支付宝账户被冻结或不允许支付,错误码:4003')
                callback && callback(false)
            } else if (ret.code == 4006) {
                alert('订单支付失败,错误码:4006')
                callback && callback(false)
            } else if (ret.code == 6001) {
                api.toast({
                    msg: '订单支付已被取消'
                });
                callback && callback(false)
            } else if (ret.code == 0001) {
                alert('支付模块缺少商户id等商户配置信息,错误码:0001')
                callback && callback(false)
            } else if (ret.code == 0002) {
                alert('支付模块缺少（subject、body、amount、tradeNO）等参数,错误码:0002')
                callback && callback(false)
            } else if (ret.code == 0003) {
                alert('支付模块中的公钥密钥与支付宝上配置的不一致,错误码:0003')
                callback && callback(false)
            } else {
                
                callback && callback(false)
            }
		});
	}
	//微信支付
	pay.prototype.weixinzhifu = function(callback) {
	     if(this.type==1)
	     {
	     var zhiurl = 'weixin/example/app.php';
	     }
	     else
	     {
	     var zhiurl = 'weixinz/example/app.php';
	     
	     }
		
		var price = this.price;
		var types =  this.type;
		var ordersid = this.ordersid;
		
		console.log($api.jsonToStr( {
					type : "login",
					zongjia : price, //支付的价格
					danhao : ordersid //单号
				}))
		api.ajax({
			url : phpurl + zhiurl, // 调取微信支付借口（前端勿管）  后台工程师配置：http://www.fondfell.com/m/api/weixin/lib/WxPay.Config.php 即可         安卓获取签名工具 ：http://www.fondfell.com/zentaopms/www/doc-view-24.html
			method : 'POST',
			timeout : '30',
			dataType : 'json',
			returnAll : false,
			cache : true,
			data : {
				values : {
					type : "login",
					zongjia : price, //支付的价格
					danhao : ordersid //单号
				}
			}
		}, function(ret, err) {
			console.log($api.jsonToStr(ret))
			console.log($api.jsonToStr(err))
			if (ret) {
				var back_info = ret;
				var weiXin = api.require('weiXin');
				weiXin.registerApp(function(ret, err) {
					if (ret.status) {
						weiXin.payOrder({
							orderId : back_info.prepayid,
							partnerId : back_info.partnerid,
							nonceStr : back_info.noncestr ,
							timeStamp : back_info.timestamp,
							package : back_info.package,
							sign : back_info.sign
						}, function(ret, err) {
							if (ret.status) {
								callback && callback(true);
							} else {
								callback && callback(false);
								if (err.code == 2) {
									api.toast({
										msg : '支付失败'
									});
								}
							}
						});
					}else{
						callback && callback(false);
						$api.t('未知错误无法支付2');
					}
				});
			} else {
				callback && callback(false);
				$api.t('未知错误无法支付1');
			}
		});
	}
	window.pay = pay;
	var ZhiFuConfig = {
		subject : '蜂蜜订单', //订单名称
		body : '蜂蜜订单', //收款方名称
		seller : '121709472@qq.com',//商户账号
		partner : '2088131540130453',//合作者ID
		//商户私钥
		rsaPriKey :'MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAM/QOdrKlPludIf6RyqhI0mZwTgVLxj5PGTlInhXM0PbNXxF0fGXprnusJCs+l4wAvyvI9gOOHdkqQ7xFqD0TdloVk2NWKBO96Quwp0GCSAoLLVXB8F6rFABROteBNAzoDuX8CUQ+WLogGYu2rZMbm1DAv/ytOglQgxLeKdCRsQhAgMBAAECgYEAhng/p4KkqU4+22oouL3yHoL+UzLp+ef0m3jlOCd8xbDHyDVJp2GxAekgmU1E6MN6e1U9BWYWRbN97Ww1b0sGP7fJSpXbfJMLjP37NVrSwvY0mMeTxSxchL7BCaIus2On9y92ObCJhUGZmC41T4mw1A5SmRH4Fq2lz/Dq1sVKIVECQQD060ZGlayC8IRcyTuriwdAjj/LnsAFarusI78Wboex7hB8uIyM3ztmOmKQnkdRHjynViADkg7dqzbk3INy3g61AkEA2TcuwwcCB0WJtRrxSYpraLktiACMJrz4QEF/U2MIrZMrsgGjczKx5oCbqR4KQjl/0j/ffXH8irVvsgpRe78XPQJBAJOnO6jWFzihc8rUbqrOmEKs/3zsaetaG2Z97nfBjwEP+tSWFfXfptnMnRt+sJQQ3JQtcgN1DI1K6T80SfL4OHkCQDD8nPMm1XJGYHQTi28GZIrNmFMfrHvgCiyTmN95ai+bDTOr4uzL9gsB3hkZyT5+MTF9bi2gU1AE8xe39ABwbBECQQDIPCOafEuEoq4BB26mrdhbPtlE7v0PlsHznXG4c2ktm0+v7sNNhtIUg7VtKiF31KTIoUMdVCTfKZvd/vIC9zvA',
		//商户公钥
		rsaPubKey : 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDP0DnaypT5bnSH+kcqoSNJmcE4FS8Y+Txk5SJ4VzND2zV8RdHxl6a57rCQrPpeMAL8ryPYDjh3ZKkO8Rag9E3ZaFZNjVigTvekLsKdBgkgKCy1VwfBeqxQAUTrXgTQM6A7l/AlEPli6IBmLtq2TG5tQwL/8rToJUIMS3inQkbEIQIDAQAB',
	};
})(window)

