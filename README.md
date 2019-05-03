# kitkat

## Set Up

### Virtual Environment and IDE 
1. Clone `kitkat` repo in a directory of your choosing
2. Create the virtual environment, we recommend `virtualenv`
  >* Enter repo directory - `cd kitkat/`
  >* Make sure it's installed - `sudo pip3 install virtualenv
  >* Create `venv` virtual environment for project - `virtualenv -p python3 venv`
3. Install an IDE, I recommend PyCharm - Download [PyCharm Community Edition](https://www.jetbrains.com/pycharm/download/#section=mac)
4. Open the `kitkat/` repo in PyCharm and set the project Python interpreter to the virtual environment. This tells PyCharm to open every terminal session within the virtual environment.
  >* Go to PyCharm > Preferences > Project: kitkat (on left pane) > Project Interpreter
  >* Make sure Project Interpreter is pointing to `venv` virtual environment

### Django
1. Open Terminal in PyCharm
2. Make sure Django is installed - `pip install Django`
3. Install required packages - `python install -r requirements.txt`
3. Check everything went fine - `python manage.py runserver`
5. Open `http://localhost:8000`. If it opens, that should indicate nothing is broken currently
6. When done, hit CTRL+C to in the terminal to stop the server

### Admin Access
1. Start the server - `python manage.py runserver`
2. Go to `http://127.0.0.1:8000/admin/`
3. Login with username: `admin`, password: `Coded3vents`
4. When done, hit CTRL+C to in the terminal to stop the server
