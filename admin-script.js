// $(document).ready(function () {
//     $(".editinline").click(function () {
//         let row = $(this).parents("tr");
//         let post_id = $(row).attr("id").replace(/.*?(\d+)/, "$1");

//         let edit_row = $('#edit-' + post_id);
//         let post_row = $('#post-' + post_id);

//         let link = $('.column-link', post_row).html();
//         setTimeout(function () {
//             console.log(link);
//             $('input[name="link"]', edit_row).val(link);
//         }, 1000);

//         let grc = !! $('.column-grc>*', post_row).attr('checked');
//         $('input[name="grc"]', edit_row).attr('checked', grc);

//         let rewrite = !! $('.column-rewrite>*', post_row).attr('checked');
//         $('input[name="rewrite"]', edit_row).attr('checked', rewrite);

//         let free_memo = $('.column-free_memo', post_row).html();
//         $('input[name="free_memo"]', edit_row).val(free_memo);
//     });
// });










