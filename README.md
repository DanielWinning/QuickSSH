# Quick SSH

QuickSSH is a command line tool that allows you to save named SSH connections and
connect to them quickly by name. Think of QuickSSH as a simple SSH credential manager.

### Pre-requisites

QuickSSH requires **PHP 7.4+** and **Composer**<span style="color: red; font-weight: bold">*</span> to 
be installed and included in your `PATH`.

<span style="color: red; font-weight: bold">*</span> On initial run, `composer install` is run to 
install the dependencies.

### Installation

1. Download the release.
2. Extract the archive into a folder on your system, for example `C:\Program Files\qssh`
3. Add the path to the QuickSSH `bin` folder to your systems `PATH` (eg. `C:\Program Files\qssh\QuickSSH-0.3.1\bin`)
4. Check QuickSSH is installed correctly by opening a new terminal and running `qssh --version`

### Usage

| Command                         | Description                          |
|---------------------------------|--------------------------------------|
| `qssh set <name> <user> <host>` | Saves a new named server             |
| `qssh connect <name>`           | Connects to a named server           |
| `qssh unset <name>`             | Removes a named server               |
| `qssh list`                     | Lists all saved servers              |
 | `qssh --version`                | Displays the QuickSSH version number |
 | `qssh --help`                   | Displays a list of valid commands    |
