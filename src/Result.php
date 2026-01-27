<?php

namespace PulseCheck;

class Result
{
    public function __construct(
        public string $id,
        public string $status,
        public string $label,
        public string $description,
        public string $confidence,
        public string $impact
    ) {}

    public function toSiteHealthFormat(): array
    {
        return [
            'status'      => $this->status,
            'label'       => $this->label,
            'description' => sprintf(
                '<p>%s</p><p><strong>Impact:</strong> %s<br><strong>Confidence:</strong> %s</p>',
                esc_html($this->description),
                esc_html($this->impact),
                esc_html($this->confidence)
            ),
            'badge' => [
                'label' => 'PulseCheck',
                'color' => 'blue',
            ],
            'test' => $this->id,
        ];
    }
}
