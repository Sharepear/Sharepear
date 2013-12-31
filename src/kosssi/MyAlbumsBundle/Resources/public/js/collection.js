"use strict"; // jshint ;_;

var Symfony = Symfony || {};

Symfony.formPrototypes = {
    addButtonContainer: '<li class="prototype-add-container"></li>',
    addButton: '<button class="prototype-add">__label__</button>',
    removeButton: '<button class="prototype-remove">__label__</button>',
    prototypes: [],

    addPrototype: function(collectionHolder) {
        this.prototypes.push(new Symfony.formPrototype(collectionHolder));
    }
};

Symfony.formPrototype = function(collectionHolder){
    this.collectionHolder = collectionHolder;
    this.prototype = this.collectionHolder.data('prototype');
    this.index = this.collectionHolder.find('input').length;
    this.limit = this.collectionHolder.data('limit');
    this.addButton = $(Symfony.formPrototypes.addButton.replace(/__label__/g, this.collectionHolder.data('prototype-label-add')));
    this.removeButton = $(Symfony.formPrototypes.removeButton.replace(/__label__/g, this.collectionHolder.data('prototype-label-remove')));
    this.addButtonContainer = $(Symfony.formPrototypes.addButtonContainer).append(this.addButton);
    this.addButtonExist = false;

    var self = this;

    // add old class for know if this children is already save in database
    this.collectionHolder.children().each(function() {
        var prototype = self.createRemoveButton($(this));

        if (prototype.find('.alert-error').length === 0) {
            prototype.addClass('old').removeClass('new').find('button').text('X');
        } else {
            prototype.addClass('error');
        }
    });

    this.toogleAddButton();
};

Symfony.formPrototype.prototype = {
    toogleAddButton: function() {
        if (this.limit === undefined || this.collectionHolder.find('input').length < this.limit) {
            this.createAddButton();
        } else {
            this.removeAddButton();
        }
    },

    createAddButton: function() {
        var self = this;

        if (!this.addButtonExist) {
            this.collectionHolder.append(this.addButtonContainer);
            this.addButtonExist = !this.addButtonExist;

            // add event in add button
            this.addButton.on('click', function(e) {
                e.preventDefault();
                self.addPrototype();
                self.clickLastPrototype();
            });
        }
    },

    removeAddButton: function() {
        if (this.addButtonExist) {
            this.collectionHolder.children('.prototype-add-container').remove();
            this.addButtonExist = !this.addButtonExist;
        }
    },

    createRemoveButton: function(prototype) {
        var self = this,
            newRemoveButton = self.removeButton.clone();

        prototype.append(newRemoveButton);

        newRemoveButton.on('click', function(e) {
            e.preventDefault();
            self.removePrototype($(this));
        });

        return prototype;
    },

    clickLastPrototype: function() {
        this.collectionHolder
            .children()
            .not('.prototype-add-container')
            .last()
            .find('input')
            .click();
    },

    addPrototype: function() {
        var newPrototype = this.prototype.replace(/__name__/g, this.index);

        // increase the index with one for the next item
        this.index++;

        // Display the input in the page before the add button
        this.addButtonContainer.before(newPrototype);

        this.createRemoveButton(this.addButtonContainer.prev());

        this.toogleAddButton();
    },

    removePrototype: function(removeButton) {
        removeButton.parent().remove();

        this.toogleAddButton();
    }
};

$(document).ready(function(){
    $('form [data-prototype]').each(function(){
        Symfony.formPrototypes.addPrototype($(this));
    });
});
