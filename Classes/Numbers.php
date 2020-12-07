<?php

	namespace Classes;

	class Numbers
	{
		public function printNumbers()
		{
			for ($i = 1; $i <= 100; $i++) {
				print $this->getNumber($i) . PHP_EOL;
			}
			return $this;
		}

		protected function getNumber($desired_number)
		{
			$result = '';
			if ($this->compare($desired_number, 3)) {
				$result .= 'Foo';
			}
			if ($this->compare($desired_number, 5)) {
				$result .= 'Bar';
			}
			if (!$result) {
				$result = $desired_number;
			}
			return $result;
		}

		private function compare($input_number, $compare_number)
		{
			if (is_int($input_number / $compare_number)) {
				return true;
			}
			return null;
		}
	}