<template>

    <div>

        <!--        <div id="autocomplete"></div>
                <div id="docs"></div>-->

        <div class="relative">
            <ais-instant-search
                :search-client="searchClient"
                index-name="envuso_docs_2.0"
            >
                <ais-configure :hits-per-page.camel="5" />

                <div class="bg-black p-4 w-full">
                    <ais-search-box
                        class="w-full"
                        @input="changed"
                        placeholder="Search for products..."
                        :class-names="{
                            'ais-SearchBox': 'w-full mb-0',
                            'ais-SearchBox-input': 'w-full p-3 bg-gray-900 text-white',
                        }"
                    />
                </div>

                <ais-hits :escapeHTML="false">
                    <template v-slot="{ items, sendEvent }">
                        <div class="search-results absolute z-10 w-full ">
                            <ul>
                                <li v-for="item in items" :key="item.objectID">
                                    <p
                                        v-if="item._highlightResult.title"
                                        class="font-bold text-md tracking-wide uppercase" v-html="item._highlightResult.title.value"
                                    >
                                    </p>
                                    <p
                                        v-if="item._highlightResult.contents"
                                        v-html="item._highlightResult.contents.value"
                                    ></p>
                                </li>
                            </ul>
                        </div>
                    </template>
                </ais-hits>

            </ais-instant-search>
        </div>
    </div>

</template>

<script>
//import { h, Fragment, render, onMounted }  from 'vue';
import algoliasearch from 'algoliasearch/lite';
//import { autocomplete, getAlgoliaResults } from '@algolia/autocomplete-js';
//import '@algolia/autocomplete-theme-classic';

const algoliaClient = algoliasearch(
    'OP5ZZIL9Y5',
    'a745bb23f1f3bf495b114f813143bc30'
);

const searchClient = {
    ...algoliaClient,
    ...algoliaClient,
    search(requests)
    {
        if (requests.every(({params}) => !params.query)) {
            return Promise.resolve({
                results : requests.map(() => ({
                    hits             : [],
                    nbHits           : 0,
                    nbPages          : 0,
                    page             : 0,
                    processingTimeMS : 0,
                })),
            });
        }

        return algoliaClient.search(requests);
    }
};

export default {
    /* setup()
     {
     onMounted(() => {
     autocomplete({
     container   : '#autocomplete',
     openOnFocus : true,
     getSources({query})
     {
     return getAlgoliaResults({
     searchClient,
     queries : [
     {
     indexName : 'envuso_docs_2.0',
     query,
     params    : {
     hitsPerPage         : 10,
     attributesToSnippet : ['title:10', 'contents:35'],
     snippetEllipsisText : '…',
     },
     },
     ],
     });
     },
     renderer : {
     createElement : h,
     Fragment,
     },
     render({children}, root)
     {
     render(children, root);
     },
     });
     });
     },*/
    data()
    {
        return {
            searchClient : searchClient
        };
    },
    methods : {
        changed(...args)
        {
            console.log(args);
        }
    }
};
</script>

