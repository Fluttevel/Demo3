resource "null_resource" "build" {
  provisioner "local-exec" {
    command = var.script
    # Directory, where script is executed
    working_dir = var.working_dir

    # Variables for script execution
    environment = {
      TAG               = var.image_tag
      DOCKER_REPO_URL   = var.docker_repo_url
      REPO_REGION       = var.aws_region
      ECR_REPO_URL      = var.ecr_repository_url
      APP_NAME          = var.app_name
      ENV_NAME          = var.environment
    }
  }
}