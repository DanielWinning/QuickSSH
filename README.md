# Quick SSH

QuickSSH is a command line tool that allows you to save named SSH connections and connect to them quickly by name. Think 
of QuickSSH as a simple SSH credential manager.

## Instructions

**Since version 0.3.5, installation is a lot simpler!**
1. Run `composer global require danielwinning/quick-ssh`.
2. Add the path to the `quick-ssh/bin` folder to your `PATH` environment variable.<span style="color: red; font-weight: bold">*</span>
3. Check that Quick SSH is successfully installed by opening a new terminal and running `qssh --version`.

<span style="color: red; font-weight: bold">*</span> When you run `composer global require danielwinning/quick-ssh`, your terminal will `cd` into your composer installations
vendor directory - note the path, on Windows this is usually something like `C:\Users\YourUserName\AppData\Roaming\Composer\vendor`, 
so the directory to add to your path would be `C:\Users\YourUserName\AppData\Roaming\Composer\vendor\danielwinning\quick-ssh\bin`. For
versions prior to 0.3.5 (not recommended), follow the installation instructions at the bottom of this page.

### Usage

| Command                         | Description                          |
|---------------------------------|--------------------------------------|
| `qssh set <name> <user> <host>` | Saves a new named server             |
| `qssh connect <name>`           | Connects to a named server           |
| `qssh unset <name>`             | Removes a named server               |
| `qssh list`                     | Lists all saved servers              |
 | `qssh --version`               | Displays the QuickSSH version number |
 | `qssh --help`                  | Displays a list of valid commands    |

> **Note:** these instructions apply only to the installation of versions prior to 0.3.5. It is not recommended to use
> QuickSSH with these versions, this is just legacy support.
>
> ### Pre-requisites
>
> QuickSSH requires **PHP 7.4+** and **Composer**<span style="color: red; font-weight: bold">*</span> to
> be installed and included in your `PATH`.
>
> <span style="color: red; font-weight: bold">*</span> On initial run, `composer install` is run to
> install the required dependencies.
>
> ### Installation
>
> Download the release.
> 
> Extract the archive into a folder on your system, for example `C:\Program Files\qssh`
> 
> Add the path to the QuickSSH `bin` folder to your systems `PATH` (eg. `C:\Program Files\qssh\QuickSSH-0.3.1\bin`)
> 
> Check QuickSSH is installed correctly by opening a new terminal and running `qssh --version`