<template>
    
    <!-- Errors -->
    <div class="alert alert-danger" v-if="errors">
        <p>There were some errors with your input:</p>
        <ul>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
    </div>

    <!-- Taxonomy Input -->
    <div class="form-group" v-if="!taxonomy">
        <label for="taxonomy">Attribute Name</label>
        <div class="input-group">
            <input class="form-control" type="text" name="taxonomy" v-model="currentTaxonomy" @keyup.enter="setTaxonomy">
            <div class="input-group-btn">
                <button class="btn btn-default" type="button" @click="setTaxonomy">Create</button>
            </div>
        </div>
    </div>

    <!-- Taxonomy Display -->
    <h2 v-if="taxonomy">{{ taxonomy }} <button class="btn btn-link" v-if="!terms.length" @click="switchTaxonomy"><i class="fa fa-pencil"></i></button></h2>

    <!-- Attribute Entry -->
    <div  v-if="taxonomy" class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="term">Add Property</label>
                <div class="input-group">
                    <input class="form-control" type="text" v-model="term" @keyup.enter="addTerm">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="button" @click="addTerm" :disabled="loading">Add Property</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <ul class="list-group">
              <li v-for="term in terms | orderBy term.order"class="list-group-item">
                  {{ term.term }} <span class="pull-right"><button class="btn-link" @click="removeTerm(term)"><i class="fa fa-fw fa-trash"></i></button></span>
              </li>
          </ul>
      </div>
  </div>

</template>

<script>

    module.exports = {
        props: ['taxonomy'],

        data: function () 
        {
            return {
                'currentTaxonomy': null,
                'term': '',
                'terms': [],
                'errors': null,
                'loading': false
            };
        },

        ready: function () 
        {
            if ('taxonomy') {
                this.fetchCurrentTerms();
            }  
        },

        'methods': {

            setTaxonomy: function ()
            {
                this.taxonomy = this.currentTaxonomy;
                this.fetchCurrentTerms();
            },

            addTerm: function ()
            {                
                var term = {
                    term: this.term,
                    taxonomy: this.taxonomy,
                    order: 1,
                };

                this.loading = true;

                this.$http.post('/api/terms', term)
                .success(function (response) {
                    this.terms.push(response);                        
                    this.term = '';
                    this.loading = false;
                })
                .error(function (response) {
                    this.displayErrors(response);
                    this.loading = false;
                });

            },

            removeTerm: function (term)
            {
                this.loading = true;

                this.$http.delete('/api/terms/' + term.id)
                .success(function (response) {
                    console.log(response);
                    this.terms.$remove(term);
                    this.loading = false;
                })
                .error(function (response) {
                    console.log(response);
                    this.loading = false;
                });
            },

            fetchCurrentTerms: function ()
            {
                this.loading = true;

                this.$http.get('/api/terms/' + this.taxonomy)
                .success(function (terms) {
                    this.terms = terms;
                    this.loading = false;
                }).error(function (response) {
                    console.log(response);
                    this.loading = false;
                });
            },

            switchTaxonomy: function ()
            {
                this.currentTaxonomy = this.taxonomy;
                this.taxonomy = null;
                this.fetchCurrentTerms();
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
            }
        }
    }

    </script>