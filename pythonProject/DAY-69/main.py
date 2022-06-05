from flask import Flask, render_template, redirect, url_for, flash,abort
from flask_bootstrap import Bootstrap
from flask_ckeditor import CKEditor
from datetime import date
from werkzeug.security import generate_password_hash, check_password_hash
from flask_sqlalchemy import SQLAlchemy
import os
from sqlalchemy.orm import relationship
from flask_login import UserMixin, login_user, LoginManager, login_required, current_user, logout_user
from forms import CreatePostForm,Register_Form, Login_Form, CommentForm
from flask_gravatar import Gravatar
from functools import wraps

app = Flask(__name__)
app.config['SECRET_KEY'] = os.environ.get("SECRET_KEY")
ckeditor = CKEditor(app)
Bootstrap(app)
gravatar = Gravatar(app,
                    size=100,
                    rating='g',
                    default='retro',
                    force_default=False,
                    force_lower=False,
                    use_ssl=False,
                    base_url=None)
##CONNECT TO DB
app.config['SQLALCHEMY_DATABASE_URI'] = os.environ.get("DATABASE_URL",  "sqlite:///blog.db")
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False
db = SQLAlchemy(app)

login=LoginManager()
login.init_app(app)
@login.user_loader
def user_loader(user_id):
    return User.query.get(int(user_id))
def admin_only(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        #If id is not 1 then return abort with 403 error
        if current_user.id != 1:
            return abort(403)
        #Otherwise continue with the route function
        return f(*args, **kwargs)
    return decorated_function

##CONFIGURE TABLES

class User(db.Model, UserMixin):
    __tablename__ = "users"
    # parent Table
    # users id is unique that's why we use them to represent author, if you have the id you can have the name (user = author )
    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(250), nullable=False)
    password = db.Column(db.String(250), nullable=False)
    email = db.Column(db.String(250), nullable=False,unique=True)
    post = relationship("BlogPost",back_populates="author") # post represent User.name or User.password also it's == author so you can call any object here using author
    comment = relationship("Comments",back_populates="author")
class BlogPost(db.Model):
    __tablename__ = "blog_posts"
    #child table
    #parent of Comments
    id = db.Column(db.Integer, primary_key=True)
    author_id = db.Column(db.Integer,db.ForeignKey("users.id"))
    author = relationship("User", back_populates="post")
    title = db.Column(db.String(250), unique=True, nullable=False)
    subtitle = db.Column(db.String(250), nullable=False)
    date = db.Column(db.String(250), nullable=False)
    body = db.Column(db.Text, nullable=False)
    img_url = db.Column(db.String(250), nullable=False)
    comments = relationship("Comments",back_populates="post")
class Comments(db.Model):
    __tablename__= "comments"
    id = db.Column(db.Integer,primary_key=True)
    author_id = db.Column(db.Integer,db.ForeignKey("users.id"))
    author = relationship("User",back_populates="comment")
    text = db.Column(db.Text(500),nullable=False)
    post_id = db.Column(db.Integer,db.ForeignKey("blog_posts.id"))
    post= relationship("BlogPost",back_populates="comments")


@app.route('/')
def get_all_posts():
    posts = BlogPost.query.all()
    return render_template("index.html", all_posts=posts,current_user=current_user)


@app.route('/register',methods=["GET","POST"])
def register():
    form = Register_Form()
    if form.validate_on_submit():
        exsist = User.query.filter_by(email = form.email.data).first()
        if not exsist:
            new_user = User(
                name = form.name.data,
                email = form.email.data,
                password = form.password.data
            )
            db.session.add(new_user)
            db.session.commit()
            login_user(new_user)
            return redirect(url_for("get_all_posts"),)
        else:
            flash("The Email is registered in the DataBase ")
            return redirect(url_for("register"))
    return render_template("register.html",form = form,current_user=current_user,)


@app.route('/login',methods = ["GET","POST"])
def login():
    form = Login_Form()
    if form.validate_on_submit():
        user=User.query.filter_by(email=form.email.data).first()
        if user and user.password == form.password.data:
            login_user(user)
            return redirect(url_for("get_all_posts"))
        else:
            flash("Username or password is incorrect")
            return redirect(url_for("login"))
    return render_template("login.html", form = form,current_user=current_user)


@app.route('/logout')
def logout():
    logout_user()
    return redirect(url_for('get_all_posts'))


@app.route("/post/<int:post_id>",methods=["GET","POST"])
def show_post(post_id):
    requested_post = BlogPost.query.get(post_id)
    form = CommentForm()
    if form.validate_on_submit():
        if current_user.is_authenticated:
            comment = Comments(
                text = form.comment.data,
                author = current_user,
                post = requested_post

            )
            db.session.add(comment)
            db.session.commit()
            return redirect(url_for("get_all_posts"))
        else:
            flash("you need to register first before you post your comment")
            return redirect(url_for("register"))

    return render_template("post.html", post=requested_post,current_user=current_user,form=form,gravatar=gravatar)

@app.route("/new-post",methods=["GET","POST"])
@admin_only
def add_new_post():
    form = CreatePostForm()
    if form.validate_on_submit():
        new_post = BlogPost(
            title=form.title.data,
            subtitle=form.subtitle.data,
            body=form.body.data,
            img_url=form.img_url.data,
            author=current_user,
            date=date.today().strftime("%B %d, %Y")
        )

        db.session.add(new_post)
        db.session.commit()
        return redirect(url_for("get_all_posts"))
    return render_template("make-post.html", form=form,current_user=current_user)


@app.route("/about")
def about():
    return render_template("about.html")


@app.route("/contact")
def contact():
    return render_template("contact.html")




@app.route("/edit-post/<int:post_id>")
@admin_only
def edit_post(post_id):
    post = BlogPost.query.get(post_id)
    edit_form = CreatePostForm(
        title=post.title,
        subtitle=post.subtitle,
        img_url=post.img_url,
        author=post.author,
        body=post.body
    )
    if edit_form.validate_on_submit():
        post.title = edit_form.title.data
        post.subtitle = edit_form.subtitle.data
        post.img_url = edit_form.img_url.data
        post.author = edit_form.author.data
        post.body = edit_form.body.data
        db.session.commit()
        return redirect(url_for("show_post", post_id=post.id))

    return render_template("make-post.html", form=edit_form)


@app.route("/delete/<int:post_id>")
@admin_only
def delete_post(post_id):
    post_to_delete = BlogPost.query.get(post_id)
    db.session.delete(post_to_delete)
    db.session.commit()
    return redirect(url_for('get_all_posts'))


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000)
