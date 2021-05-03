$(function () {
    const client = algoliasearch('5IQ7K6MTBD', '0767156b25554c88561603b3ccc591bd');
    const products = client.initIndex('products');
    const language = getLanguage();
    let author_text = language == 'vn' ? 'Tác giả:' : 'Author:';
    let publish_text = language == 'vn' ? 'Xuất bản:' : 'Publish:';
    let page_text = language == 'vn' ? 'Số trang:' : 'Pages:';
    let not_found_text = language == 'vn' ? 'Xin lỗi, chúng tôi không tìm thấy kết quả cho' : 'Sorry, we did not find any results for';

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
                                        <p class="info-author ml-2">${author_text} ${suggestion._highlightResult.author.value}</p>
                                        <p class="info-details ml-2">${publish_text} ${suggestion.publish_date}, ${page_text} ${suggestion.page}</p>
                                    </div>                            
                            </div>
                           <div class="algolia-details">                  
                                <span>${suggestion.discount.toLocaleString('it-IT', {style: 'currency', currency: 'VND'})}</span>
                            </div>
                        </div>
                      `;

                    return markup;
                },
                empty     : function (result) {
                    return `${not_found_text} "` + result.query + '"';
                }
            }
        }).on('autocomplete:selected', function (event, suggestion, dataset) {
        window.location.href = window.location.origin +'/'+ language +'/home/shop/' + suggestion.slug;
        enterPressed = true;
        })

});