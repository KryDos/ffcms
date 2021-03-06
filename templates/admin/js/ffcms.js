var changed_path = false;
$(document).ready(function () {
    $('#setcurrentdate').change(function () {
        var $event_click = $(this);
        if ($event_click.is(':checked')) {
            $('#datefield').attr("disabled", true).val('');
        }
        else {
            $('#datefield').removeAttr("disabled");
        }
    });
    var df = $('#out').val();
    if(df != null && df.length > 0) {
        changed_path = true;
    }
    $('tr.checkbox-depend').click(function(event) {
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
    $('.keywords_count').click(function(){
        var item_lang = this.id;
        var c_selector = null;
        for(var s=0;s<Jobject.length;s++) {
            if(Jobject[s]['id'] == 'keywords_'+item_lang) {
                c_selector = Jobject[s].selectize;
                break;
            }
        }
        var text = $('#textobject'+item_lang+'.wysi').val();
        if(text.length < 1)
            text = CKEDITOR.instances['textobject'+item_lang].getData();
        var words_top = top_words(text, 15, 2);

        for(var d=0;d<words_top.length;d++){
            c_selector.addOption({
                text:words_top[d],
                value: words_top[d]
            });
            c_selector.addItem(words_top[d]);
        }
    });
});
function posterDelete(id) {
    $.get(ffcms_host+'/api.php?iface='+loader+'&object=newsposterdelete&id='+id, function(){
        $('#posterobject').remove();
    });
}
function gallerydel(name, id) {
    $.get(ffcms_host+'/api.php?iface='+loader+'&object=jqueryfile&action=delete&name='+name+'&id='+id);
    document.getElementById(name).remove();
}
function pathCallback()
{
    changed_path = true;
}

function top_words(text, count, repeat_time) {
    // cleanup from html tags
    var html = document.createElement("div");
    html.innerHTML = text;
    text = html.textContent || html.innerText || "";
    // Split text on non word characters
    var words = text.toLowerCase().split(/\W+/);
    var positions = new Array();
    var word_counts = new Array();
    var word_output = new Array();
    for (var i=0; i<words.length; i++) {
        var word = words[i];
        if (!word) {
            continue
        }

        if (typeof positions[word] == 'undefined') {
            positions[word] = word_counts.length;
            word_counts.push([word, 1])
        } else {
            word_counts[positions[word]][1]++
        }
    }
    // Put most frequent words at the beginning.
    word_counts.sort(function (a, b) {return b[1] - a[1]});
    if(repeat_time < 1)
        repeat_time = 1;
    // check is repeat more then repeat_time
    for(var c=0;c<word_counts.length;c++) {
        if(word_counts[c][1] >= repeat_time && word_counts[c][0].length > 3)
            word_output.push(word_counts[c][0]);
    }
    return word_output.slice(0,count);
}

function grep(str) {
    var ar = new Array();
    var arSub = 0;
    for (var i in this) {
        if (typeof this[i] == "string" && this[i].indexOf(str) != -1) {
            ar[arSub] = this[i];
            arSub++;
        }
    }
    return ar;
}
Array.prototype.remove = function (s) {
    for (i = 0; i < this.length; i++) {
        if (s == this[i]) this.splice(i, 1);
    }
}

Array.prototype.grep = grep;


function JSTranslit() {
    this.strTranslit = function (el) {
        new_el = document.getElementById('out');
        A = new Array();
        A["Ё"] = "YO";
        A["Й"] = "I";
        A["Ц"] = "TS";
        A["У"] = "U";
        A["К"] = "K";
        A["Е"] = "E";
        A["Н"] = "N";
        A["Г"] = "G";
        A["Ш"] = "SH";
        A["Щ"] = "SCH";
        A["З"] = "Z";
        A["Х"] = "H";
        A["Ъ"] = "";
        A["ё"] = "yo";
        A["й"] = "i";
        A["ц"] = "ts";
        A["у"] = "u";
        A["к"] = "k";
        A["е"] = "e";
        A["н"] = "n";
        A["г"] = "g";
        A["ш"] = "sh";
        A["щ"] = "sch";
        A["з"] = "z";
        A["х"] = "h";
        A["ъ"] = "";
        A["Ф"] = "F";
        A["Ы"] = "I";
        A["В"] = "V";
        A["А"] = "A";
        A["П"] = "P";
        A["Р"] = "R";
        A["О"] = "O";
        A["Л"] = "L";
        A["Д"] = "D";
        A["Ж"] = "ZH";
        A["Э"] = "E";
        A["ф"] = "f";
        A["ы"] = "i";
        A["в"] = "v";
        A["а"] = "a";
        A["п"] = "p";
        A["р"] = "r";
        A["о"] = "o";
        A["л"] = "l";
        A["д"] = "d";
        A["ж"] = "zh";
        A["э"] = "e";
        A["Я"] = "YA";
        A["Ч"] = "CH";
        A["С"] = "S";
        A["М"] = "M";
        A["И"] = "I";
        A["Т"] = "T";
        A["Ь"] = "";
        A["Б"] = "B";
        A["Ю"] = "YU";
        A["я"] = "ya";
        A["ч"] = "ch";
        A["с"] = "s";
        A["м"] = "m";
        A["и"] = "i";
        A["т"] = "t";
        A["ь"] = "";
        A["б"] = "b";
        A["ю"] = "yu";
        A[" "] = "-";
        if (!changed_path) {
            new_el.value = el.value.replace(/[^A-Za-z0-9\u0410-\u0451_ ]/g, '').replace(/([\u0410-\u0451 ])/g,
                function (str, p1, offset, s) {
                    if (A[str] != 'undefined') {
                        return A[str].toLowerCase();
                    }
                }
            ).replace(/[A-Z]/g,
                function (data) {
                    return data.toLowerCase();
                }
            );
        }
    }
    /* Normalizes a string, eю => eyu */
    this.strNormalize = function (el) {
        if (!el) {
            return;
        }
        this.strTranslit(el);
    }
}
var oJS = new JSTranslit();