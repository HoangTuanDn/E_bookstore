$(function () {
    const client = algoliasearch('5IQ7K6MTBD', '0767156b25554c88561603b3ccc591bd');
    const products = client.initIndex('products');
    const language = getLanguage();

    autocomplete('#aa-search-input',
        {hint: false}, {
            source    : autocomplete.sources.hits(products, {hitsPerPage: 5}),
            //value to be displayed in input control after user's suggestion selection
            displayKey: 'name',
            //hash of templates used when rendering dataset
            templates : {
                //'suggestion' templating function used to render a single suggestion
                suggestion: function (suggestion) {
                    const markup = `
                        <div class="algolia-content">
                             <div class="algolia-result">
                                     <div class="algolia-img">
                                        <img width="50px" height="69px" src="${window.location.origin}${suggestion.featured_img}" alt="img" class="algolia-thumb">
                                     </div>                     
                                   
                                    <div class="algolia-info">
                                        <p class="info-name ml-2"><strong>${suggestion._highlightResult.name.value}</strong></p>
                                        <p class="info-author ml-2">Author: ${suggestion._highlightResult.author.value}</p>
                                        <p class="info-details ml-2">Publish: ${suggestion.publish_date}, Pages: ${suggestion.page}</p>
                                    </div>                            
                            </div>
                           <div class="algolia-details">                  
                                <span>${suggestion.price.toLocaleString('it-IT', {style: 'currency', currency: 'VND'})}</span>
                            </div>
                        </div>
                      `;

                    return markup;
                },
                empty     : function (result) {
                    return 'Sorry, we did not find any results for "' + result.query + '"';
                }
            }
        }).on('autocomplete:selected', function (event, suggestion, dataset) {
        window.location.href = window.location.origin +'/'+ language +'/home/shop/' + suggestion.slug;
        enterPressed = true;
        })

});