@extends('layouts.app')

@section('content')

	<div id="container"><div>

@endsection

@push('scripts')

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react-dom.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>
	<script type="text/babel">

		{/* Container Component */}
		var Container = React.createClass({
			render: function() {
				return (
					<div>
						<div className="row">
							<div className="div-centered-large">
								<h1 className="display-3 hidden-sm-down spacer p-y-2">Doppie er af - Board</h1>
								<h3 className="hidden-md-up spacer"></h3>
							</div>
						</div>
						<div className="row">
							<Board />
						</div>
					</div>
				);
			}
		});

		{/* Board Component */}
		var Board = React.createClass({
			getInitialState: function() {
				return {
					comments: [
						"I like bacon",
						"I want icecream",
						"Nuff said"
					]
				}
			},

			removeComment: function(i) {
				var arr = this.state.comments;
				arr.splice(i, 1);
				this.setState({comments: arr})
			},

			editComment: function(i, newText) {
				var arr = this.state.comments;
				arr[i] = newText;
				this.setState({comments: arr});
			},

			eachComment: function(comment, i) {
				return (
					<Comment key={i} index={i} editComment={this.editComment} removeComment={this.removeComment}>
						{comment}
					</Comment>
				);
			},

			render: function() {
				return (
					<div className="container">
						<div className="card-columns">
							{this.state.comments.map(this.eachComment)}
						</div>
					</div>
				);
			}
		});

		{/* Comment Component */}
		var Comment = React.createClass({
			getInitialState: function() {
				return {editing: false}
			},
			edit: function() {
				this.setState({editing: true});
			},
			remove: function() {
				this.props.removeComment(this.props.index);
			},
			save: function() {
				this.props.editComment(this.props.index, this.refs.newText.value);
				this.setState({editing: false});
			},
			renderNormal: function() {
				return(
					<div className="card">
						<div className="card-block">
							<div className="card-title">{this.props.children}</div>
						</div>
						<div className="card-footer">
							<button onClick={this.edit} className="btn btn-primary">Edit</button>
							<button onClick={this.remove} className="btn btn-danger">Remove</button>
						</div>
					</div>
				);
			},
			renderForm: function() {
				return(
					<div className="card">
						<div className="card-block">
							<div className="form-group">
								<textarea ref="newText" className="form-control" rows="5" defaultValue={this.props.children}></textarea>
							</div>
						</div>
						<div className="card-footer">
							<button onClick={this.save} className="btn btn-success">Save</button>
						</div>
					</div>
				);
			},
			render: function() {
				if (this.state.editing) {
					return this.renderForm();
				} else {
					return this.renderNormal();
				}
			}
		});


		ReactDOM.render(
			<Container />
			, document.getElementById("container")
		);
	</script>

@endpush

