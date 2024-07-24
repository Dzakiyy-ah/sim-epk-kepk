<div class="profile-user-info profile-user-info-striped">
	<div class="profile-info-row">
		<div class="profile-info-name"> Username </div>

		<div class="profile-info-value">
			<span class="editable" id="username"><?php echo isset($data['username']) ? $data['username'] : ''?></span>
		</div>
	</div>

	<div class="profile-info-row">
		<div class="profile-info-name"> Nama </div>

		<div class="profile-info-value">
			<span class="editable" id="nama"><?php echo isset($data['nama']) ? $data['nama'] : ''?></span>
		</div>
	</div>

	<div class="profile-info-row">
		<div class="profile-info-name"> Email </div>

		<div class="profile-info-value">
			<span class="editable" id="email"><?php echo isset($data['email']) ? $data['email'] : ''?></span>
		</div>
	</div>
</div>

<div class="space-20"></div>

<button type="button" class="btn" id="edit_passw">
	<i class="ace-icon fa fa-pencil align-top bigger-125"></i>Ganti Password
</button>