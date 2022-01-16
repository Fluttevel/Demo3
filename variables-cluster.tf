# ==========| VARIABLES FOR "CLUSTER" MODULE |==========

variable "task_definition_template" {
  description = "Template JSON file for resource task_definition"
  type        = string
  default     = "container_definitions.json.tpl"
}


variable "launch_type" {
  description = "FARGATE - AWS-managed infrastructure"
  type        = string
  default     = "FARGATE"
}

variable "network_mode" {
  description = "Network mode"
  type        = string
  default     = "awsvpc"
}

variable "fargate_cpu" {
  description = "Fargate instance CPU units to provision (1 vCPU = 1024 CPU units)"
  type        = string
  default     = "256"
}

variable "fargate_memory" {
  description = "Fargate instance memory to provision (in MiB)"
  type        = string
  default     = "512"
}













variable "protocol_tcp" {
  description = "Protocol 'TCP'"
  type        = string
  default     = "tcp"
}

locals {
  container_name  = format("%s-%s-app", var.app_name, var.environment)
  app_image       = format("%s/%s-%s:%s", var.ecr_repository_url, var.app_name, var.environment, var.image_tag)
}