# =========| GLOBAL VARIABLES |=========

variable remote_state_bucket_prefix {}
variable environment {}
variable app_name {}
variable aws_profile {}
variable aws_account {}
variable aws_region {}
variable image_tag {}
variable docker_repo_url {}
variable branch_pattern {}
variable git_trigger_event {}
variable app_count {}
variable ecr_repository_url {}


# =========| LOCAL VARIABLES |=========

variable "script" {
  description = "Build script file"
  type        = string
  default     = "docker-script.sh"
}

variable "working_dir" {
  description = "Application location"
  type        = string
  default     = "./app"
}

locals {
  repository_name = format("%s-%s", var.app_name, var.environment)
  app_image = format("%s:%s", var.ecr_repository_url, var.image_tag)
}

variable "taskdef_template" {
  description = "AWS Task Definition template"
  type        = string
  default     = "cp_app.json.tpl"
}

variable "fargate_cpu" {
  description = "Fargate instance CPU units to provision (1 vCPU = 1024 CPU units)"
  default     = "512"
}

variable "fargate_memory" {
  description = "Fargate instance memory to provision (in MiB)"
  default     = "1024"
}

variable "app_port" {
  description = "Port exposed by the docker image to redirect traffic to"
  default     = 80
}

variable "az_count" {
  description = "Number of AZs to cover in a given region"
  type        = string
  default     = "2"
}

variable "ecs_task_execution_role_name" {
  description = "ECS task execution role name"
  default = "TaskExecutionRole"
}

variable "ecs_task_role_name" {
  description = "ECS task role name"
  default = "TaskRole"
}
