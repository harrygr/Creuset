<template>

    <!-- Errors -->
    <div class="alert alert-danger" v-if="errors">
        <p>There were some errors with your input:</p>
        <ul>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
    </div>

    <!-- Attribute Input -->
    <div class="form-group" v-if="!product_attribute">
        <label for="product_attribute">Attribute Name</label>
        <div class="input-group">
            <input class="form-control" type="text" name="product_attribute" v-model="currentAttribute" @keyup.enter="setAttribute">
            <div class="input-group-btn">
                <button class="btn btn-default" type="button" @click="setAttribute">Create</button>
            </div>
        </div>
    </div>

    <!-- Attribute Display -->
    <h2 v-if="product_attribute">{{ product_attribute }} <button class="btn btn-link" v-if="!properties.length" @click="switchAttribute"><i class="fa fa-pencil"></i></button></h2>

    <!-- Properties -->
    <div  v-if="product_attribute" class="row">

        <!-- Property Entry -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="property">Add Property</label>
                <div class="input-group">
                    <input class="form-control" type="text" v-model="property" @keyup.enter="addProperty">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="button" @click="addProperty" :disabled="loading">Add Property</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attribute Display -->
        <div class="col-md-6">
            <ul class="list-group">
              <li v-for="property in properties | orderBy 'order'"class="list-group-item">

                <div v-if="!(editingProperty == property.id)" style="max-width:50%; display:inline;">
                    {{ property.property }} <span class='text-muted'>({{ property.order}})</span>
                    <button class="btn btn-link" @click="editingProperty = property.id"><i class="fa fa-pencil"></i></button>
                </div>

                <div v-if="editingProperty == property.id" style="max-width:50%; display:inline-block;">

                    <div class="input-group" >
                      <input type="text" class="form-control input-sm" v-model="property.property" @keyup.enter="updateProperty(property)">
                      <span class="input-group-btn">
                        <button class="btn btn-default btn-sm" type="button" @click="updateProperty(property)" title="Save Edit"><span class="text-success"><i class="fa fa-check"></i></span></button>
                        <button class="btn btn-default btn-sm" @click="editingProperty = null" title="Cancel Edit"><i class="fa fa-times"></i></button>
                      </span>
                    </div><!-- /input-group -->

                </div>


                <span class="pull-right" v-if="!editingProperty">
                    <button class="btn-link" @click="promote($index)" :disabled="$index === 0"><i class="fa fa-fw fa-arrow-up"></i></button>
                    <button class="btn-link" @click="demote($index)" :disabled="$index === (properties.length - 1)"><i class="fa fa-fw fa-arrow-down"></i></button>
                    <button class="btn btn-link" @click="removeProperty(property)"><span class="text-danger"><i class="fa fa-fw fa-trash"></i></span></button>
                </span>
            </li>
        </ul>

        <!-- Loading messages -->
        <p class="form-group top-buffer">
        <span v-if="loading"><i class="fa fa-circle-o-notch fa-spin"></i> Working...</span>
        <span class="text-success" v-if="updatedMessage"> <i class="fa fa-check"></i> {{ updatedMessage }}</span>
        </p>

    </div>
</div>

</template>

<script>

    var sluggify = require('../filters/sluggify.js');

    module.exports = {
        props: ['product_attribute'],

        data: function ()
        {
            return {
                'currentAttribute': null,
                'property': '',
                'properties': [],
                'errors': null,
                'loading': false,
                'editingProperty': null,
                'updatedMessage': '',
            };
        },

        ready: function ()
        {
            if (this.product_attribute) {
                this.fetchCurrentProperties();
            }
        },

        'methods': {

            setAttribute: function ()
            {
                this.product_attribute = this.currentAttribute;
                this.fetchCurrentProperties();

            },
            addProperty: function ()
            {
                var property = {
                    property: this.property,
                    property_slug: sluggify(this.property),
                    name: this.product_attribute,
                    order: this.properties.length + 1,
                };

                this.loading = true;

                this.$http.post('/api/product_attributes', property)
                .then(function (response) {
                    this.properties.push(response.data);
                    this.property = '';
                    this.loading = false;
                    this.showMessage('Property Saved');
                })
                .catch(function (response) {
                    this.displayErrors(response.data);
                    this.loading = false;
                });

            },

            removeProperty: function (property)
            {
                this.loading = true;

                this.$http.delete('/api/product_attributes/' + property.id)
                .then(function (response) {
                    this.properties.$remove(property);
                    this.loading = false;
                    this.showMessage('Property Deleted');
                })
                .catch(function (response) {
                    this.loading = false;
                });
            },

            fetchCurrentProperties: function ()
            {
                this.loading = true;

                this.$http.get('/api/product_attributes/' + this.product_attribute)
                .then(function (response) {
                    this.properties = response.data;
                    this.loading = false;

                    this.reindexItems();
                }).catch(function (response) {
                    this.loading = false;
                });
            },

            switchAttribute: function ()
            {
                this.currentAttribute = this.product_attribute;
                this.property = null;
                this.fetchCurrentAttributes();
            },

            displayErrors: function(errors)
            {
                this.errors = errors;

                var errorDisplayTime = 5000;

                // Wait a bit and reset the errors
                setTimeout(function()
                {
                    this.errors = null;
                }.bind(this), errorDisplayTime);
            },

            reindexItems: function() {

                this.properties = this.$options.filters.orderBy(this.properties, 'order');

                for (var ind = 0; ind < this.properties.length; ind++) {
                    this.properties[ind].order = ind;
                }
            },

            promote: function(index) {

                this.reindexItems();

                if (index !== 0) {
                    var newOrder = this.properties[index - 1].order;

                    this.properties[index - 1].order = this.properties[index].order;
                    this.updateProperty(this.properties[index - 1]);

                    this.properties[index].order = newOrder;
                    this.updateProperty(this.properties[index]);
                }

            },

            demote: function(index) {

                this.reindexItems();

                if ((index + 1) !== this.properties.length) {
                    var newOrder = this.properties[index + 1].order;

                    this.properties[index + 1].order = this.properties[index].order;
                    this.updateProperty(this.properties[index + 1]);

                    this.properties[index].order = newOrder;
                    this.updateProperty(this.properties[index]);

                }

            },

            updateProperty: function(property) {

                this.loading = true;
                property.property_slug = sluggify(property.property);

                this.$http.patch('/api/product_attributes/' + property.id, property)
                .then(function(response){
                    this.editingProperty = null;
                    this.loading = false;
                    this.showMessage('Property Updated');
                        })
                .catch(function(response){});
            },

            showMessage: function(message) {
                this.updatedMessage = message;
                setTimeout(function(){ this.updatedMessage = false}.bind(this), 5000);
            },
        }
    }

</script>
