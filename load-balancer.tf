# =========| LOAD BALANCER |=========

resource "aws_lb" "alb" {
  name               = "terraform-alb-${var.app_name}-${var.environment}"
  load_balancer_type = var.load_balancer_type # type = ALB
  subnets            = aws_subnet.public.*.id
  security_groups    = [aws_security_group.http.id]
}