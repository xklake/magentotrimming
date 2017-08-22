/**
 * @copyright    Copyright (C) 2015 KtmVelo. All Rights Reserved.
 */

Catalog.Map.showHelp = Catalog.Map.showHelp.wrap(function (parent, event) {
    var helpBox = $('map-popup');
    var bodyNode = $$('body')[0];

    // Resolve calculation bug in parent so we can actually use these classes...
    if (helpBox && this != Catalog.Map && Catalog.Map.active != this.link) {
        parent(event);

        helpBox.removeClassName('map-popup-right');
        helpBox.removeClassName('map-popup-left');
        if (Element.getWidth(bodyNode) < event.pageX + (Element.getWidth(helpBox) / 2)) {
            helpBox.addClassName('map-popup-left');
        } else if (event.pageX - (Element.getWidth(helpBox) / 2) < 0) {
            helpBox.addClassName('map-popup-right');
        }
    } else {
        parent(event);
    }
});
