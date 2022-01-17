# ================================================== #
# =======|   C L U S T E R    M O D U L E   |======= #
# ================================================== #



# ==========| ECR REPOSITORY |==========
resource "aws_ecr_repository" "ecr_repository" {
  name = "${var.app_name}-${var.environment}"
}



# ==========| ECS CLUSTER |==========
resource "aws_ecs_cluster" "main" {
  name = "${var.app_name}-${var.environment}-cluster"
}



# ==========| ECS TASK DEFINITION |==========
resource "aws_ecs_task_definition" "app" {
  family                   = "${var.app_name}-${var.environment}-task"
  execution_role_arn       = aws_iam_role.ecs_task_execution_role.arn
  task_role_arn            = aws_iam_role.ecs_task_role.arn
  network_mode             = var.network_mode
  requires_compatibilities = [var.launch_type]
  cpu                      = var.fargate_cpu
  memory                   = var.fargate_memory

  container_definitions    = data.template_file.container_definitions.rendered
}



# ==========| ECS SERVICE |==========
resource "aws_ecs_service" "main" {
  name            = "${var.app_name}-${var.environment}-service"
  cluster         = aws_ecs_cluster.main.id
  task_definition = aws_ecs_task_definition.app.arn
  desired_count   = var.app_count
  launch_type     = var.launch_type

  network_configuration {
    security_groups  = [aws_security_group.http.id]
    subnets          = aws_subnet.private.*.id # var.private_subnets_id # out
    assign_public_ip = true
  }

  load_balancer {
    target_group_arn = aws_lb_target_group.alb.id # var.lb_target_group_id # out
    container_name   = local.container_name
    container_port   = var.server_port
  }

  depends_on = [aws_lb_listener.http, aws_iam_role_policy.ecs_task_execution_role]
}



# ==========| IAM ROLE FOR TASK EXECUTION |==========
resource "aws_iam_role" "ecs_task_execution_role" {
  name               = "${var.app_name}-${var.environment}-${var.ecs_task_execution_role_name}"
  assume_role_policy = data.aws_iam_policy_document.ecs_task_execution_role.json
}



# ==========| IAM ROLE POLICY FOR TASK EXECUTION |==========
resource "aws_iam_role_policy" "ecs_task_execution_role" {
  name_prefix = "ecs_iam_role_policy"
  role        = aws_iam_role.ecs_task_execution_role.id
  policy      = data.template_file.ecs_service_policy.rendered
}



# ==========| IAM ROLE FOR TASK |==========
resource "aws_iam_role" "ecs_task_role" {
  name               = "${var.app_name}-${var.environment}-${var.ecs_task_role_name}"
  assume_role_policy = <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Action": "sts:AssumeRole",
      "Principal": {
        "Service": "ecs-tasks.amazonaws.com"
      },
      "Effect": "Allow",
      "Sid": ""
    }
  ]
}
EOF
}



# ==========| IAM ROLE POLICY FOR TASK |==========
resource "aws_iam_role_policy" "ecs_task_role" {
  name = "${var.app_name}-${var.environment}-${var.ecs_task_role_name}"
  role = aws_iam_role.ecs_task_role.id
  policy = <<EOF
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "s3:Get*",
                "s3:List*"
            ],
            "Resource": "*"
        }
    ]
}
EOF
}



# ==========| SECURITY GROUP |==========
resource "aws_security_group" "http" {
  name        = "Security Group access to HTTP for ${var.app_name}-${var.environment}"
  description = "Enable HTTP access on Port ${var.server_port}"
  vpc_id      = aws_vpc.vpc.id # var.vpc_id # out

  ingress {
    description = "HTTP Access"
    from_port   = var.server_port
    to_port     = var.server_port
    protocol    = var.protocol_tcp
    cidr_blocks = [var.cidr_block_0]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = [var.cidr_block_0]
  }

  tags   = {
    Name = "Security Group access to HTTP for ${var.app_name}-${var.environment}"
  }
}