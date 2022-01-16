# ==========| ECS |==========

resource "aws_ecs_cluster" "main" {
  name = "${var.app_name}-${var.environment}-cluster"
}

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

resource "aws_ecs_service" "main" {
  name            = "${var.app_name}-${var.environment}-service"
  cluster         = aws_ecs_cluster.main.id
  task_definition = aws_ecs_task_definition.app.arn
  desired_count   = var.app_count
  launch_type     = var.launch_type

  network_configuration {
    security_groups  = [aws_security_group.http.id]
    subnets          = aws_subnet.private.*.id
    assign_public_ip = true
  }

  load_balancer {
    target_group_arn = aws_lb_target_group.alb.id
    container_name   = local.container_name
    container_port   = var.app_port
  }

  depends_on = [aws_lb_listener.http, aws_iam_role_policy.ecs_task_execution_role]
}