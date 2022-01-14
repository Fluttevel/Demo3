# =========| LOAD BALANCER |=========

resource "aws_lb" "demo" {
  name               = "terraform-asg-demo"
  load_balancer_type = "application" # type = ALB
  subnets            = [aws_subnet.public-subnet-1.id, aws_subnet.public-subnet-2.id]
  security_groups    = [aws_security_group.alb-security-group.id]
}