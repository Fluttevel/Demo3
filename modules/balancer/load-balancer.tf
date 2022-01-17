# =========| LOAD BALANCER |=========

resource "aws_lb" "alb" {
  name               = "terraform-alb-${var.app_name}-${var.environment}"
  load_balancer_type = var.load_balancer_type # type = ALB
  subnets            = var.vpc_id # out
  security_groups    = [var.public_subnets_id] # out
}