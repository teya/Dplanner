(function(a){a.fn.tablePagination=function(c){var b={rowsPerPage:5,currPage:1,optionsForRows:[5,10,25,50,100],ignoreRows:[],topNav:false};c=a.extend(b,c);return this.each(function(){var l=a(this)[0];var n,h,d,v,k,g,s;n="#tablePagination_totalPages";h="#tablePagination_currPage";d="#tablePagination_rowsPerPage";v="#tablePagination_firstPage";k="#tablePagination_prevPage";g="#tablePagination_nextPage";s="#tablePagination_lastPage";var q=(b.topNav)?"prev":"next";var j=a.makeArray(a("tbody tr",l));var i=a.grep(j,function(w,x){return(a.inArray(w,b.ignoreRows)==-1)},false);var o=i.length;var p=f();var u=(b.currPage>p)?1:b.currPage;if(a.inArray(b.rowsPerPage,b.optionsForRows)==-1){b.optionsForRows.push(b.rowsPerPage)}function e(x){if(x==0||x>p){return}var z=(x-1)*b.rowsPerPage;var y=(z+b.rowsPerPage-1);a(i).show();for(var w=0;w<i.length;w++){if(w<z||w>y){a(i[w]).hide()}}}function f(){var w=Math.round(o/b.rowsPerPage);var x=(w*b.rowsPerPage<o)?w+1:w;if(a(l)[q]().find(n).length>0){a(l)[q]().find(n).html(x)}return x}function m(w){if(w<1||w>p){return}u=w;e(u);a(l)[q]().find(h).val(u)}function t(){var x=false;var w=b.optionsForRows;w.sort(function(B,A){return B-A});var z=a(l)[q]().find(d)[0];z.length=0;for(var y=0;y<w.length;y++){if(w[y]==b.rowsPerPage){z.options[y]=new Option(w[y],w[y],true,true);x=true}else{z.options[y]=new Option(w[y],w[y])}}if(!x){b.optionsForRows==w[0]}}function r(){var w=[];w.push("<div id='tablePagination'>");w.push("<span id='tablePagination_perPage'>");w.push("<select id='tablePagination_rowsPerPage'><option value='5'>5</option></select>");w.push("per page");w.push("</span>");w.push("<span id='tablePagination_paginater'>");w.push("<img id='tablePagination_firstPage' src='"+b.firstArrow+"'>");w.push("<img id='tablePagination_prevPage' src='"+b.prevArrow+"'>");w.push("Page");w.push("<input id='tablePagination_currPage' type='input' value='"+u+"' size='1'>");w.push("of <span id='tablePagination_totalPages'>"+p+"</span>");w.push("<img id='tablePagination_nextPage' src='"+b.nextArrow+"'>");w.push("<img id='tablePagination_lastPage' src='"+b.lastArrow+"'>");w.push("</span>");w.push("</div>");return w.join("").toString()}if(a(l)[q]().find(n).length==0){if(b.topNav){a(this).before(r())}else{a(this).after(r())}}else{a(l)[q]().find(h).val(u)}t();e(u);a(l)[q]().find(v).bind("click",function(w){m(1)});a(l)[q]().find(k).bind("click",function(w){m(u-1)});a(l)[q]().find(g).bind("click",function(w){m(parseInt(u)+1)});a(l)[q]().find(s).bind("click",function(w){m(p)});a(l)[q]().find(h).bind("change",function(w){m(this.value)});a(l)[q]().find(d).bind("change",function(w){b.rowsPerPage=parseInt(this.value,10);p=f();m(1)})})}})(jQuery);