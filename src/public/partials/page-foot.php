</div>

<script src="<?= ASSETS_URL ?>/js/app.js"></script>
<script>
	// Tooltips
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

	// Feedback toasts
	const feedbackToast = document.getElementById('feedbackToast')
	const bsToast = new bootstrap.Toast(feedbackToast)
	bsToast.show()		
</script>

</body>

</html>
