/*! Select2wpupg 4.0.2 | https://github.com/select2wpupg/select2wpupg/blob/master/LICENSE.md */

(function(){if(jQuery&&jQuery.fn&&jQuery.fn.select2wpupg&&jQuery.fn.select2wpupg.amd)var e=jQuery.fn.select2wpupg.amd;return e.define("select2wpupg/i18n/it",[],function(){return{errorLoading:function(){return"I risultati non possono essere caricati."},inputTooLong:function(e){var t=e.input.length-e.maximum,n="Per favore cancella "+t+" caratter";return t!==1?n+="i":n+="e",n},inputTooShort:function(e){var t=e.minimum-e.input.length,n="Per favore inserisci "+t+" o più caratteri";return n},loadingMore:function(){return"Caricando più risultati…"},maximumSelected:function(e){var t="Puoi selezionare solo "+e.maximum+" element";return e.maximum!==1?t+="i":t+="o",t},noResults:function(){return"Nessun risultato trovato"},searching:function(){return"Sto cercando…"}}}),{define:e.define,require:e.require}})();