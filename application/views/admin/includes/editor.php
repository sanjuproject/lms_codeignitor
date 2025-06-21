 <script src="<?php echo base_url(); ?>assets/libs/quill/quill.min.js"></script>
        <script>
            var quill = new Quill("#snow-editor", {
    theme: "snow",
    modules: {
        toolbar: [
            [{
                font: []
            }, {
                size: []
            }],
            ["bold", "italic", "underline", "strike"],
            [{
                color: []
            }, {
                background: []
            }],
            [{
                script: "super"
            }, {
                script: "sub"
            }],
            [{
                header: [!1, 1, 2, 3, 4, 5, 6]
            }, "blockquote", "code-block"],
            [{
                list: "ordered"
            }, {
                list: "bullet"
            }, {
                indent: "-1"
            }, {
                indent: "+1"
            }],
            ["direction", {
                align: []
            }],
            ["link", "image", "video"],
            ["clean"]
        ]
    }
});
        </script>
<link href="<?php echo base_url(); ?>assets/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/libs/quill/quill.bubble.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />       
</body>
</html>