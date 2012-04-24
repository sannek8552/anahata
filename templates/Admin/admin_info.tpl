{config_load file=templates.ini section="common" scope="global"}
<div class="content-container">
  <h2>Admin - User Profile</h2>
  <p>Please note, if you wish to change both your user name and password, you must save each one individually before changing the other.</p>

</div>
<div class="form-container">
  <form name="submit_form" id="submit_form" action="" method="post">
    <fieldset name="information" id="information">
      <legend>User Name</legend>
    
    <table width="400">
      
      {if $user_name_error}
  <tr>
    <td colspan="2" style="color:red">Not valid user name</td>
  </tr>
      {/if}
      {if $user_name_good}
  <tr>
    <td colspan="2" style="color:blue;">User name changed</td>
  </tr>
      {/if}
  <tr>
    <td width="35%"><strong>Change:</strong></td>
    <td><input type="text" name="user_name" value="{$u_data.login}"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="save_user_name" value="Save" class="submit-button" /></td>
  </tr>
    </table>
    </fieldset>
    <fieldset name="display" id="display">
    <legend>Change Password</legend>
    
    <table width="400">
      
      {if $invalid_password}
  <tr>
    <td colspan="2" style="color:red;">Invalid Password</td>
  </tr>
      {/if}
      {if $password_good}
  <tr>
    <td colspan="2" style="color:blue;">Password Changed</td>
  </tr>
      {/if}
  <tr>
    <td width="35%"><strong>New Password:</strong></td>
    <td><input type="password" name="new_password" /></td>
  </tr>
  <tr>
    <td><strong>Retype Password:</strong></td>
    <td><input type="password" name="retype_new_password" /></td>
  </tr>
  <tr>
    <td>&nbsp;
        <t/d>    </td>
    <td><input type="submit" name="save_password" value="Save" class="submit-button"/></td>
  </tr>
    </table>
    </fieldset>
  </form>
</div>
