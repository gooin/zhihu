<template>
    <div>
        <button
                class="button is-naked delete-button"
                @click="showCommentsForm"
                v-text="text"
        >
        </button>
        <div class="modal fade" tabindex="-1" role="dialog" :id="dialog">
            <!--<div class="modal fade" tabindex="-1" role="dialog" id="dialog">-->
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">评论列表</h4>
                    </div>
                    <div class="modal-body">
                        <div v-if="comments.length > 0">
                            <div>
                                <div class="media" v-for="comment in comments">
                                    <div class="media-left">
                                        <a href="#">
                                            <img width="30" class="media-object" :src="comment.user.avatar">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{comment.user.name}}</h4>
                                        {{comment.body}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" class="form-control" v-model="body">
                            <button type="button" class="btn btn-primary" @click="store">评论</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    export default {
        props: ['type', 'model', 'count'],
        data() {
            return {
                body: '',
                comments: [],
                newComment: {
                    user: {
                        name: Zhihu.name,
                        avatar: Zhihu.avatar,
                    },
                    body: ''
                }
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        computed: {
            dialog() {
                return 'comments-dialog-' + this.type + '-' + this.model
            },

            dialogId() {
                return '#' + this.dialog
            },

            text() {
                return this.count + ' 评论'
            }
        },

        methods: {
            store() {
                this.$http.post('/api/comment', {'type': this.type, 'model': this.model, 'body': this.body})
                    .then(response => {
//                        console.log(response.data)
                        this.newComment.body = response.data.body;
                        this.comments.push(this.newComment);
                        this.body = '';
                    })


            },

            showCommentsForm() {
                this.getComponents()
                $(this.dialogId).modal('show')
//                $('#dialog').modal('show')
            },
            getComponents() {
                // todo 问题及答案下面如果有评论，get 请求会出错 ，没有评论时可以 get 请求正常
//                this.$http.get('/api/' + this.model + '/comments').then(response => {
                this.$http.get('/api/' + this.type + '/' + this.model + '/comments').then(response => {
                    this.comments = response.data;
                    console.log(response.data);
//                    this.comments = response.data;
                })
            }
        }
    };
</script>
