<script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('[name="_token"]').getAttribute('value');
    new Vue({
        el  : '#app',
        data: {
            done:false,
            doned:false,
            isEmpty: false,
            comments  : [],
            newMessage: {
                name  :"{{Auth::user()->name}}",
                avatar:"{{Auth::user()->avatar}}",
                body  :""
            },
            newComment  : {
                discussion_id:"{{ $discussion->id }}",
                body:""
            }
        },
        ready:function(){

        },
        methods: {
            onSubmitForm: function () {
                var message = this.newMessage;
                var comment = this.newComment;
                comment.body = message.body;
                if (comment.body != '') {
                    this.isEmpty = false;
                    this.$http.post('/discuss/{{ $discussion->id }}/replies', comment).then(function(response) {
                        message.body = response.data.html;
                        this.comments.push(message);
                    });
                } else {
                    this.isEmpty = true
                }
                this.newMessage = {
                    name  :"{{ Auth::user()->name }}",
                    avatar:"{{ Auth::user()->avatar }}",
                    body  :""
                };
            },
            onFavorite  : function () {
                var id = {discussion_id: '{{ $discussion->id }}'};
                this.$http.post('/favorite', id).then(function () {
                    $('.discussion_star span').toggle();
                });

            },
            deFavorite  : function () {
                var id = {discussion_id: '{{ $discussion->id }}'};
                this.$http.delete('/favorite/'+'{{ $discussion->id }}', id).then(function () {
                    $('.discussion_star span').toggle();
                });

            }
        }
    });
</script>