# ==========| DECLARATION OF GLOBAL VARIABLES |==========

variable aws_account {}
variable aws_region {}
variable ecr_repository_url {}
variable app_name {}
variable environment {}
variable image_tag {}
variable app_count {}
variable script {}
variable working_dir {}
variable server_port {}











variable "app_port" {
  description = "Port exposed by the docker image to redirect traffic to"
  default     = 80
}

variable "count_value" {
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
