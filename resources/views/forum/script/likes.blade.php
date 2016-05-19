<script type="text/x-template" id="likes-template">
    <div class="thumbs-like">
        <button class="likes-submit" @click="doLike()">
            <i class="fa fa-lg fa-thumbs-o-up" :class="{ 'is-liked': liked }"></i>
            <span v-show="likes" v-text="likes"></span>
        </button>
    </div>
    <ul class="participation__footer__like-list  list-inline pull-right">
        <li class="label label-default" v-for="user in users">@{{ user }}</li>
    </ul>
</script>

<script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    var MyComponent = Vue.extend({
        template: '#likes-template',

        props:['commentId','currentUser','userLiked'],

        data: function() {
            return {
                replyId:'',
                liked: false,
                current:'',
                likes: 0,
                users: []
            };
        },

        ready: function() {
            this.users = this.userLiked.length > 0 ? this.userLiked.split(',') : [];
            this.likes = this.users.length;
            this.liked  = this.users.indexOf(this.currentUser) > -1;
        },

        methods: {
            doLike: function() {
                if(this.currentUser.length > 0){
                    this.liked = ! this.liked;
                    if ( this.liked) {
                        this.likes++;
                        this.addUserToList();
                    } else {
                        this.likes--;
                        this.removeUserFromList();
                    }
                }else{
                    document.querySelector('#loginButton').click();
                }

            },

            addUserToList: function() {
                this.current = this.currentUser;
                var votes = {'comment_id': this.commentId, 'name': this.current };
                this.$http.post('/likes/votes', votes,function(response){ });
                this.users.push(this.current);
            },

            removeUserFromList: function() {
                this.current = this.currentUser;
                var votes = {'comment_id':this.commentId,'name':this.current};
                this.$http.post('/likes/cancel', votes,function(response){
                });
                this.users.$remove(this.current);
            }
        }
    });
    Vue.component('forum-post-like-button', MyComponent);
    new Vue({ el: '#Reply_list' });
</script>