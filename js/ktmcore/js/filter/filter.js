/**
 * @copyright    Copyright (C) 2015 KtmVelo. All Rights Reserved.
 */
;'use strict';

var KtmCoreFilter = Class.create();
KtmCoreFilter.prototype = {
    container: null,
    layer: null,
    name: null,
    initialize: function(name, config){
        this.name = name;
        this.config = config;
        if (this.config.enable){
            if (this.config.bar){
                NProgress.configure({
                    showSpinner: true,
                    easing: 'ease',
                    speed: 200,
                    minimum: 0.1,
                    trickleRate: 0.05,
                    trickleSpeed: 500
                });
            }
            document.observe('dom:loaded', function(){
                this.collect();
            }.bind(this));
        }
    },
    collect: function(){
        this.toolbar = $$('.main-top-inner .toolbar')[0];
        this.layer = $$('.block-layered-nav')[0];
		this.main = $$('.col-main')[0];
		this.toolbarBot = $$('.toolbar-bottom .toolbar')[0];
        this.initLinkFilter();
		
    },
    setConfig: function(obj){
        Object.extend(this.config, obj);
    },
    initLinkFilter: function(){
        if (this.toolbar){
            this.toolbar.select('a').each(function(a){
                $(a).observe('click', function(ev){
                    var a = Event.findElement(ev, 'a'),
                        URL = new URI(a.href);

                    if (URL.hasQuery('p') || URL.hasQuery('order') || URL.hasQuery('mode')){
                        Event.stop(ev);
                        this.sendRequest(a.href);
                    }
                }.bind(this));
            }, this);
        }
		
		if (this.toolbarBot){
            this.toolbarBot.select('a').each(function(a){
                $(a).observe('click', function(ev){
                    var a = Event.findElement(ev, 'a'),
                        URL = new URI(a.href);

                    if (URL.hasQuery('p') || URL.hasQuery('order') || URL.hasQuery('mode')){
                        Event.stop(ev);
                        this.sendRequest(a.href);
                    }
                }.bind(this));
            }, this);
        }
		
        if (this.layer){
            this.layer.select('a').each(function(a){
                $(a).observe('click', function(ev){
                    var a = Event.findElement(ev, 'a');
                    Event.stop(ev);
                    this.sendRequest(a.href);
                }.bind(this));
            }, this);
        }
    },
    initPriceFilter: function(obj){
        var slider      = $(obj.id),
            handles     = slider.select('.price-slider-handle'),
            minText     = $('layer-price-min'),
            maxText     = $('layer-price-max'),
            range       = $R(obj.min, obj.max),
            URL         = new URI(obj.url);

        minText.update(obj.values[0]);
        maxText.update(obj.values[1]);
        var sliderObj = new Control.Slider(handles, slider, {
            range: range,
            sliderValue: obj.values,
            spans: slider.select('.price-slider-span'),
            restricted: true,
            onSlide: function(values){
                minText.update(Math.floor(values[0]));
                maxText.update(Math.ceil(values[1]));
            },
            onChange: function(values){
                var priceMin = Math.floor(values[0]),
                    priceMax = Math.ceil(values[1]);

                sliderObj.setDisabled();
                URL.setQuery('price', priceMin + '-' + priceMax);
                this.sendRequest(URL.toString(), function(){
                    sliderObj.setEnabled();
                });
            }.bind(this)
        });
    },
    getParams: function(){
        return {
            isAjax: true
        };
    },
    setAjaxLocation: function(url){
        var url = arguments[0],
            URL = new URI(url);

        if (URL.hasQuery('limit') || URL.hasQuery('order')){
            this.sendRequest(url);
        }else setLocation(url);
    },
    sendRequest: function(url, success, error){
        if (this.config.enable){
            if (this.config.bar) NProgress.start();
            new Ajax.Request(url, {
                parameters: this.getParams(),
                onSuccess: function(transport){
                    try{
                        var response = transport.responseText.evalJSON(),
                            main = response.main ? response.main.replace(/setLocation/g, this.name+'.setAjaxLocation') : null,
                            layer = response.layer || null,
							toolbar = response.toolbar || null;

                        if (this.toolbar && this.toolbar) this.toolbar.update(toolbar);
						if (this.toolbarBot && this.toolbar) this.toolbarBot.update(toolbar);
						if (main && this.main) this.main.update(main);
                        if (layer && this.layer) this.layer.replace(layer);
                        //setGridItem($ktm);
                        setTimeout(function(){
                            this.collect();
                        }.bind(this));
                        if (success) success(transport);
                    }catch(e){
                        console.log(e.message);
                    }
                }.bind(this),
                onFailure: function(transport){
                    if (error) error(transport);
                },
                onComplete: function(){
                    if (this.config.bar) NProgress.done();
                    ConfigurableMediaImages.ajaxLoadSwatchList();
                }.bind(this)
            });
        }else{
            setLocation(url);
        }
    }
};
