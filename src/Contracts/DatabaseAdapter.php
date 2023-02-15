<?php

declare (strict_types = 1);

namespace Larke\Auth\Contracts;

use Casbin\Persist\BatchAdapter;

interface DatabaseAdapter extends BatchAdapter
{
}
