var CommentModel = Backbone.Model.extend({
    urlRoot: '/comments',
    defaults:{
    	id:0,
    	comment: '',
    	media_id: 0,
    	user_id:0,
    	created_at:'',
    	updated_at:'',
    },
    validate: function( attributes ){
        if( attributes.comment == '' || attributes.media_id == 0 ){
            return "You must enter a valid comment";
        }
    },
});
    

var CommentView = Backbone.View.extend({
    className: "answer",
    template: _.template( $('#new-answer-template').html() ),
    initialize: function(){
    	this.render();
    },
    render: function(){

        this.$el.html( this.template(this.model.toJSON()) );
        $('#current_answers').prepend(this.$el);
        if(this.model.get('user_id') == $('#user_id').val()){
        	this.$el.prepend( '<div class="edit_delete_comment"><a class="edit_comment">edit</a><a class="delete_comment">delete</a></div>' );
        }

    }
});

var CommentCollection = Backbone.Collection.extend({

	model: CommentModel,

});

var CommentCollectionView = Backbone.View.extend({

	initialize: function(){
    	this.render();
    },
	render: function(){
		this.collection.each(function(answer){
			//console.log(answer);
			var newCommentView = new CommentView({ model: answer });
		});

		$('.delete_comment').bind('click', function(){
			comment_id = $(this).parent().next('.answer_container').data('id');
			var mod = commentCollection.get(comment_id);
			mod.destroy();
		});
	}
});