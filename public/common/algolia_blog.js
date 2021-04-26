$(function () {
    const client = algoliasearch('5IQ7K6MTBD', '0767156b25554c88561603b3ccc591bd');
    const blogs = client.initIndex('blogs');
    const language = getLanguage();
    var options = {year: 'numeric', month: 'short', day: 'numeric' };

    autocomplete('#aa-search-input-blog',
        {hint: false}, {
            source    : autocomplete.sources.hits(blogs, {hitsPerPage: 5}),
            displayKey: 'name',
            templates : {
                //'suggestion' templating function used to render a single suggestion
                suggestion: function (suggestion) {
                    const markup = `
                        <div class="algolia-content">
                             <div class="algolia-result">
                                     <div class="algolia-img">
                                        <img width="50px" height="50px" src="${window.location.origin}${suggestion.featured_img}" alt="img" class="algolia-thumb">
                                     </div>                     
                                   
                                    <div class="algolia-info">
                                        <p class="info-name ml-2"><strong>${suggestion._highlightResult.name[language].value}</strong></p>
                                        <p class="info-details ml-2">${language === 'vn' ? new Date(suggestion.created_at).toLocaleDateString("vi-VN", options) : new Date(suggestion.created_at).toLocaleDateString("en-US", options)}</p>
                                    </div>                            
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
        window.location.href = window.location.origin +'/'+ language +'/home/blog/' + suggestion.slug[language];
        enterPressed = true;
    });

});